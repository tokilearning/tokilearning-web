<?php

Yii::import("ext.contest.ContestTypeHandler");
Yii::import("ext.contest.types.ioi2010.model.TokenUsage");

//Yii::import("ext.contest.HandlerInterface");

class Ioi2010Handler extends ContestTypeHandler /* implements HandlerInterface */ {

    const ACTION_REQUEST_RELEASE = 101;
    const CACHE_KEY_SUBMISSIONS = "submissions";

    public function getReleaseLevel($pSubmission) {
        $retval = Submission::RELEASE_LEVEL_BLIND;
        
        if ($pSubmission->contest_id == $this->contest->id && (
                !$this->contest->getConfig('secret') ||
                $this->contest->isOwner(Yii::app()->user) ||
                $this->contest->isSupervisor(Yii::app()->user) ||
                $this->contest->getConfig('fullfeedback') && $pSubmission->getSubmitContent('fullfeedback')
                )) {
            $retval = Submission::RELEASE_LEVEL_FULL;
        }
        
        return $retval;
    }
    
    public function getSupervisorMenu() {
        return array(
            0 => 'Stat'
        );
    }

    public function getContestantMenu() {
        return array(
            0 => Yii::t('evaluator', 'Nilai Resmi')
        );
    }

    public function getSupervisorMenuWidget($pIndex = 0) {
        if ($pIndex == 0) {
            //$this->controller->widget($this->getContestTypePathAlias() . '.widgets.ProblemStatWidget', array('handler' => $this));
            $this->controller->widget($this->getContestTypePathAlias() . '.widgets.TokenStatWidget', array('handler' => $this));
        }
    }

    public function getContestLogText($pContestLog) {
        $tAction = $pContestLog->action_type;
        if ($tAction == self::ACTION_REQUEST_RELEASE)
            return "Memakai token";
    }

    public function getContestLogRemarks($pContestLog) {
        $tAction = $pContestLog->action_type;
        if ($tAction == self::ACTION_REQUEST_RELEASE) {
            $tRemarks = json_decode($pContestLog->log_content, true);
            $submission = Submission::model()->findByPK($tRemarks['submission_id']);
            return CHtml::link($submission->problem->title, array('contest/supervisor/submission/view/id/' . $submission->id));
        }
    }

    public function getContestantMenuWidget($pIndex = 0) {
        if ($pIndex == 0) {
            if (isset($_GET['submissionid'])) {
                $submission = Submission::model()->findByPK($_GET['submissionid']);

                if ($this->contest->getConfig('token') && $submission !== null && !$submission->getSubmitContent('fullfeedback') &&  $submission->contest_id == $this->contest->id && $this->useToken($submission->submitter , $submission->problem) /*$this->getAvailableTokens() > 0*/ && !$this->contest->isExpired()) {
                    $submission->setSubmitContent('fullfeedback', true);
                    $submission->save();

                    $log = new ContestLog('Create');
                    $log->contest_id = $this->contest->id;
                    $log->actor_id = Yii::app()->user->id;
                    $log->action_type = self::ACTION_REQUEST_RELEASE;
                    $log->log_content = json_encode(array('submission_id' => $submission->id));
                    $log->save();
                }
            }

            $this->controller->widget($this->getContestTypePathAlias() . '.widgets.ContestantReleaseWidget', array('handler' => $this));
        }
    }
    
    protected function useToken($contestant , $problem) {
        $record = TokenUsage::findFix($this->contest, $contestant, $problem);
        $retval = $record->useToken();
        return $retval;
    }
    
    public function getSubmissionRemarks($pSubmission) {
        if ($this->contest->getConfig('secret') != null && !$this->contest->getConfig('secret'))
            return "Off.Score : " . $pSubmission->getGradeContent('official_result');
    }

    public function getAvailableTokensForProblem($problem) {
        if ($this->contest->isExpired())
            return 0;
        return TokenUsage::findFix($this->getContest() , Yii::app()->user , $problem)->amount;
    }
    
    public function getAvailableTokens() {
        if ($this->contest->isExpired())
            return 0;
        
        $criteria = new CDbCriteria();
        $criteria->condition = "submitter_id = " . Yii::app()->user->id . " AND contest_id = " . $this->contest->id . " AND submitted_time >= '" . $this->contest->start_time . "'";
        $submissions = Submission::model()->findAll($criteria);

        $usedTokens = 0;
        foreach ($submissions as $submission) {
            if ($submission->getSubmitContent('fullfeedback'))
                $usedTokens++;
        }

        if ($this->contest->getConfig('token')) {
            ///TODO: implement token regen
            return ($this->contest->getConfig('max_token') - $usedTokens >= 0) ? $this->contest->getConfig('max_token') - $usedTokens : 0;
        } else {
            return 0;
        }
    }

    public function getAvailableTokensFor($pUser) {
        if ($this->contest->isExpired())
            return 0;

        $criteria = new CDbCriteria();
        $criteria->condition = "submitter_id = " . $pUser->id . " AND contest_id = " . $this->contest->id;
        $submissions = Submission::model()->findAll($criteria);

        $usedTokens = 0;
        foreach ($submissions as $submission) {
            if ($submission->getSubmitContent('fullfeedback'))
                $usedTokens++;
        }

        if ($this->contest->getConfig('token')) {
            ///TODO: implement token regen
            return ($this->contest->getConfig('max_token') - $usedTokens >= 0) ? $this->contest->getConfig('max_token') - $usedTokens : 0;
        } else {
            return 0;
        }
    }
    
    public function clearSubmissionsCache() {
        Yii::app()->cache->delete(self::CACHE_KEY_SUBMISSIONS);
    }
    
    protected function cacheSubmissions($pSubmissions) {
        Yii::app()->cache->set(self::CACHE_KEY_SUBMISSIONS , $pSubmissions , 3600);
    }

    public function getRankedSubmissions($pContest, $official = false) {
        $contestants = $pContest->members;
        $contestants[] = $pContest->owner;
        $problems = $pContest->problems;
        $retval = array();
        $caching = false;
        
        ///Checks cache existence
        $cachedSubmissions = Yii::app()->cache->get(self::CACHE_KEY_SUBMISSIONS);
        if ($cachedSubmissions == null) {
            ///Cache must be built
            $caching = true;
            $cachedSubmissions = array();
        }
        else {
            ///Use open problems only
            $problems = $pContest->openproblems;
        }

        foreach ($contestants as $contestant) {
            foreach ($problems as $problem) {
                $criteria = new CDbCriteria;
                $criteria->condition = "contest_id = $pContest->id AND submitter_id = $contestant->id AND problem_id = $problem->id";
                $criteria->order = "id DESC";

                $submissions = Submission::model()->findAll($criteria);

                /* $criteria->condition = "contest_id = $pContest->id AND submitter_id = $contestant->id AND problem_id = $problem->id";
                  $criteria->limit = 1;
                  $lastSubmission = Submission::model()->find($criteria); */

                $lastSubmission = NULL;
                if (count($submissions) !== 0) {
                    $lastSubmission = $submissions[0];
                }
                //echo $lastSubmission->id . " ";

                if ($lastSubmission !== NULL) {
                    $maxReleased = 0;
                    $releasedSubmission = NULL;
                    foreach ($submissions as $submission) {
                        if ($submission->getSubmitContent('fullfeedback')) {
                            if ($submission->getGradeContent('official_result') > $maxReleased) {
                                $maxReleased = $submission->getGradeContent('official_result');
                                $releasedSubmission = $submission;
                            }
                        }
                    }

                    if ($official)
                        $lastSubmission->score = ($lastSubmission->getGradeContent('official_result') !== NULL) ? $lastSubmission->getGradeContent('official_result') : $lastSubmission->score;

                    $selectedSubmission = NULL;
                    if ($maxReleased > $lastSubmission->score)
                        $selectedSubmission = $releasedSubmission;
                    else
                        $selectedSubmission = $lastSubmission;
                    
                    if ($caching && $pContest->getProblemStatus($problem) != Contest::CONTEST_PROBLEM_OPEN) {///Cache target
                        $cachedSubmissions[] = $selectedSubmission;
                    }
                    
                    $retval[] = $selectedSubmission;
                }
            }
        }
        
        if ($caching) {
            $this->cacheSubmissions($cachedSubmissions);
        }
        else {
            foreach ($cachedSubmissions as $sub) {
                $retval[] = $sub;
            }
        }
        
        return $retval;
    }

    public function beforeEvaluate($pContest, $pSubmission) {
        
    }

    public function afterEvaluate($pContest, $pSubmission) {
        
    }

    public function beforeEnter($pContest, $pUser) {
        
    }

    public function afterEnter($pContest, $pUser) {
        
    }

    public function beforeSubmit($pContest, $pSubmission) {
        
    }

    public function afterSubmit($pContest, $pSubmission) {
        /* 		if (!$pContest->getConfig('secret')) {
          $tSubmission = Submission::model()->findByPK($pSubmission->id);
          $tSubmission->setSubmitContent('fullfeedback', true);
          $tSubmission->save(false);
          } */
        ContestLog::submitSolution($pSubmission->submitter_id, $pContest->id, $pSubmission->id);
    }

}
