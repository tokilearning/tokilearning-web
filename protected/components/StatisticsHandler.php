<?php

class StatisticsHandler {

    private $first_update = '2009-11-09 06:04:50';
    //
    private $submissions;
    private $problems;
    private $users;
    //
    private $statpath;
    private $problemstatpath;
    private $submissionstatpath;
    private $userstatpath;
    //
    private $problemstat = array();
    private $submissionstat = array();
    private $userstat = array();
    private static $instance;

    //
    private function __construct() {
        $this->init();
    }

    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new StatisticsHandler();
        }
        return self::$instance;
    }

    public function init() {
        $this->statpath = Yii::app()->basePath . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "statistics" . DIRECTORY_SEPARATOR;
        //
        $this->readSubmissionStatFile();
        $this->readProblemStatFile();
        $this->readUserStatFile();
    }

    private function readProblemStatFile() {
        $this->problemstatpath = $this->statpath . "problemstat.json";
        $this->problemstat = CJSON::decode(file_get_contents($this->problemstatpath));
    }

    private function readSubmissionStatFile() {
        $this->submissionstatpath = $this->statpath . "submissionstat.json";
        $this->submissionstat = CJSON::decode(file_get_contents($this->submissionstatpath));
    }

    private function readUserStatFile() {
        $this->userstatpath = $this->statpath . "userstat.json";
        $this->userstat = CJSON::decode(file_get_contents($this->userstatpath));
    }

    public function getSubmissionStat() {
        if (!isset($this->submissionstat)) {
            $this->readSubmissionStatFile();
        }
        return $this->submissionstat;
    }

    public function getProblemStat() {
        if (!isset($this->problemstat)) {
            $this->readProblemStatFile();
        }
        return $this->problemstat;
    }

    public function getUserStat() {
        if (!isset($this->userstat)) {
            $this->readUserStatFile();
        }
        return $this->userstat;
    }

    public function resetStatistics() {
        $this->userstat = array();
        $this->problemstat = array();
        $this->submissionstat = array();
    }

    public function computeStatistics($reset = true) {
        if ($reset)
            $this->resetStatistics();
        ini_set('memory_limit', '256M');
        //TODO: mark last
        $nonlearners = User::model()->findAll(array(
                    'select' => 'id, type',
                    'join' => 'LEFT JOIN groups_users ON id = user_id',
                    'condition' => 'group_id IN (1,2) OR type = 1'
                ));
        $arnonlearners = array();
        foreach ($nonlearners as $nl)
            $arnonlearners[] = $nl->id;
        $this->submissions = Submission::model()->with(array(
                    'problem' => array('select' => 'id, visibility, problem_type_id'),
                    'submitter' => array(
                        'select' => 'id', 'full_name',
                    ),
                ))->findAll(array(
                    'select' => 'id, problem_id, submitter_id, verdict, submitted_time, submit_content, grade_content',
                    'condition' => 'problem_type_id = 1 AND visibility = 1'
                ));
        //$this->problems = Problem::model()->public()->findAll();
        //$this->users = User::model()->findAll();
        $this->problemstat['popular']['weekly'] = array();
        $this->problemstat['popular']['daily'] = array();
        $lastweek = strtotime('-1 week');
        $yesterday = strtotime('-1 day');
        foreach ($this->submissions as $submission) {
            $problem_id = $submission->problem_id;
            $submitter_id = $submission->submitter_id;
            if (in_array($submitter_id, $arnonlearners))
                continue;
            $this->problemstat['problems'][$problem_id]['submissions']['count']++;
            //
            $submitted_time = strtotime($submission->submitted_time);
            if ($submitted_time >= $lastweek){
                $this->problemstat['popular']['weekly'][$submission->problem_id]++;
            }
            //
            if ($submitted_time >= $yesterday){
                $this->problemstat['popular']['daily'][$submission->problem_id]++;
            }
            //
            $this->userstat['users'][$submitter_id]['submissions']['count']++;
            if ($submission->verdict == 'Accepted') {
                $this->problemstat['problems'][$problem_id]['submissions']['accepted']++;
                $this->userstat['users'][$submitter_id]['submissions']['accepted']++;
                if (!is_array($this->userstat['users'][$submitter_id]['problems']['accepted'])) {
                    $this->userstat['users'][$submitter_id]['problems']['accepted'] = array(
                        $problem_id
                    );
                } else if (!in_array($problem_id, $this->userstat['users'][$submitter_id]['problems']['accepted'])) {
                    $this->userstat['users'][$submitter_id]['problems']['accepted'][] = $problem_id;
                }
                if (is_array($this->userstat['users'][$submitter_id]['problems']['not_accepted']) && in_array($problem_id, $this->userstat['users'][$submitter_id]['problems']['not_accepted'])) {
                    self::array_remove($this->userstat['users'][$submitter_id]['problems']['not_accepted'], $problem_id);
                }
            } else {
                $this->problemstat['problems'][$problem_id]['submissions']['not_accepted']++;
                $this->userstat['users'][$submitter_id]['submissions']['not_accepted']++;
                if (!is_array($this->userstat['users'][$submitter_id]['problems']['not_accepted'])) {
                    $this->userstat['users'][$submitter_id]['problems']['not_accepted'] = array(
                        $problem_id
                    );
                } else if (!in_array($problem_id, $this->userstat['users'][$submitter_id]['problems']['not_accepted'])) {
                    $this->userstat['users'][$submitter_id]['problems']['not_accepted'][] = $problem_id;
                }
            }
            $source_lang = $submission->getSubmitContent('source_lang');
            switch ($source_lang) {
                case 'cpp' :
                    $this->submissionstat['source_lang']['cpp']++;
                    $this->userstat['users'][$submitter_id]['submissions']['source_lang']['cpp']++;
                    $this->problemstat['problems'][$problem_id]['submissions']['source_lang']['cpp']++;
                    break;
                case 'pas':
                    $this->submissionstat['source_lang']['pas']++;
                    $this->userstat['users'][$submitter_id]['submissions']['source_lang']['pas']++;
                    $this->problemstat['problems'][$problem_id]['submissions']['source_lang']['pas']++;
                    break;
                case 'c':
                    $this->submissionstat['source_lang']['c']++;
                    $this->userstat['users'][$submitter_id]['submissions']['source_lang']['c']++;
                    $this->problemstat['problems'][$problem_id]['submissions']['source_lang']['c']++;
                    break;
            }
        }
        if (isset($this->problemstat['problems']) && count($this->problemstat['problems']) > 0)
            uasort($this->problemstat['problems'], 'self::cmpProblemSubmissionCount');
        if (isset($this->userstat['users']) && count($this->userstat['users']) > 0)
            uasort($this->userstat['users'], 'self::cmpUserAcceptedCount');
        $ac_count = -1;
        $rank = 0;
        foreach($this->userstat['users'] as &$user){
            if (isset($user['submissions']['accepted'])){
				if($user['submissions']['accepted'] != $ac_count){
					$rank++;
					$ac_count = $user['submissions']['accepted'];
				}
				$user['rank'] = $rank;
            }
        }
        arsort($this->problemstat['popular']['weekly']);
        arsort($this->problemstat['popular']['daily']);
        $this->save();
    }

    private static function cmpProblemSubmissionCount($a, $b) {
        if ($a['submissions']['count'] == $b['submissions']['count']) {
            return 0;
        }
        return ($a['submissions']['count'] > $b['submissions']['count']) ? -1 : 1;
    }

    private static function array_remove($arr, $value) {
        return array_values(array_diff($arr, array($value)));
    }

    private static function cmpUserAcceptedCount($a, $b) {
        $ca = count($a['problems']['accepted']);
        $cb = count($b['problems']['accepted']);
        if ($ca == $cb) {
            return 0;
        }
        return ($ca > $cb) ? -1 : 1;
    }

    public function save($update_time = null) {
        if (!isset($update_time)) {
            $update_time = date("Y-m-d H:i:s");
        }
        $this->problemstat['last_update'] = $update_time;
        $this->submissionstat['last_update'] = $update_time;
        $this->userstat['last_update'] = $update_time;
        //
        file_put_contents($this->problemstatpath, PJSON::indent(CJSON::encode($this->problemstat)));
        file_put_contents($this->submissionstatpath, PJSON::indent(CJSON::encode($this->submissionstat)));
        file_put_contents($this->userstatpath, PJSON::indent(CJSON::encode($this->userstat)));
    }

}
