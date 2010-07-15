<?php

Yii::import("ext.contest.ContestTypeHandler");

/**
 *
 */
class Contest extends CActiveRecord {

    const CONTEST_VISIBILITY_PRIVATE = 0;
    const CONTEST_VISIBILITY_PUBLIC = 1;
    const CONTEST_VISIBILITY_CONDITIONED = 2;
    //
    const CONTEST_MEMBER_SUPERVISOR = 1;
    const CONTEST_MEMBER_CONTESTANT = 2;
    const CONTEST_MEMBER_REGISTRANT = 3;
    const CONTEST_MEMBER_OBSERVER = 4;
    //
    const CONTEST_PROBLEM_HIDDEN = 0;
    const CONTEST_PROBLEM_OPEN = 1;
    const CONTEST_PROBLEM_CLOSED = 2;
    const CONTEST_SPAN_TYPE_FIXED = 0;
    const CONTEST_SPAN_TYPE_VIRTUAL = 1;

    public $startDate;
    public $startTime;
    public $endDate;
    public $endTime;
    public $_aliases;
    public $_statuses = null;
    private $mConfig = array();
    private $mHandler = NULL;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{contests}}';
    }

    public function relations() {
        return array(
            'logs' => array(self::HAS_MANY, 'ContestLog', 'contest_id'),
            'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
            'members' => array(self::MANY_MANY, 'User', 'contests_users(contest_id, user_id)'),
            'contesttype' => array(self::BELONGS_TO, 'ContestType', 'contest_type_id'),
            'supervisors' => array(self::MANY_MANY, 'User',
                'contests_users(contest_id, user_id)',
                'condition' => 'role=' . self::CONTEST_MEMBER_SUPERVISOR
            ),
            'contestants' => array(self::MANY_MANY, 'User',
                'contests_users(contest_id, user_id)',
                'condition' => 'role=' . self::CONTEST_MEMBER_CONTESTANT
            ),
            'invitations' => array(self::MANY_MANY, 'User',
                'contests_users(contest_id, user_id)',
                'condition' => 'role=' . self::CONTEST_MEMBER_REGISTRANT
            ),
            'observers' => array(self::MANY_MANY, 'User',
                'contests_users(contest_id, user_id)',
                'condition' => 'role=' . self::CONTEST_MEMBER_OBSERVER
            ),
            'problems' => array(self::MANY_MANY, 'Problem',
                'contests_problems(contest_id, problem_id)'
            ),
            'openproblems' => array(self::MANY_MANY, 'Problem',
                'contests_problems(contest_id, problem_id)',
                'condition' => 'status=' . self::CONTEST_PROBLEM_OPEN
            ),
            'nonhiddenproblems' => array(self::MANY_MANY, 'Problem',
                'contests_problems(contest_id, problem_id)',
                'condition' => 'status!=' . self::CONTEST_PROBLEM_HIDDEN
            ),
            'nonopenproblems' => array(self::MANY_MANY, 'Problem',
                'contests_problems(contest_id, problem_id)',
                'condition' => 'status!=' . self::CONTEST_PROBLEM_OPEN
            ),
        );
    }

    public function defaultScope() {
        return array('order' => 'start_time DESC, end_time DESC');
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Nama',
            'description' => 'Deskripsi',
            'start_time' => 'Waktu Mulai',
            'end_time' => 'Waktu Selesai',
            'owner_id' => 'Manajer',
            'span_type' => 'Jenis'
        );
    }

    public function rules() {
        return array(
            array('name, description, status', 'required'),
            array('startDate, endDate', 'match', 'pattern' => '/^[0-9][0-9]\/[0-9][[0-9]\/[0-9][0-9][0-9][0-9]$/', 'on' => 'create'),
            array('startTime, endTime', 'match', 'pattern' => '/^[0-9][0-9]:[0-9][[0-9]$/', 'on' => 'create'),
            array('contest_type_id', 'required', 'on' => 'create, update'),
            array('startDate, startTime, endDate, endTime, start_time, end_time', 'required', 'on' => 'create'),
            array('startDate, startTime, endDate, endTime, start_time, end_time, span_type', 'required', 'on' => 'update'),
                //array('configuration' , 'safe' , 'on' => 'update')
        );
    }

    public function getContestTypeHandler() {
        if ($this->mHandler === NULL) {
            $this->mHandler = ContestTypeHandler::getHandler($this);
        }

        return $this->mHandler;
    }

    public function afterFind() {
        if ($this->start_time != null) {
            $t = strtotime($this->start_time);
            $this->startDate = date('m/d/Y', $t);
            $this->startTime = date('H:i', $t);
        }
        if ($this->end_time != null) {
            $t = strtotime($this->end_time);
            $this->endDate = date('m/d/Y', $t);
            $this->endTime = date('H:i', $t);
        }

        $this->mConfig = json_decode($this->configuration, true);
        return parent::afterFind();
    }

    public function beforeSave() {
        $this->configuration = json_encode($this->mConfig);
        return parent::beforeSave();
    }

    public function getConfig($key) {
        if (isset($this->mConfig[$key]))
            return $this->mConfig[$key];
        else
            return null;
    }

    public function setConfig($key, $value) {
        $this->mConfig[$key] = $value;
    }

    public static function getContestVisibilityStrings() {
        return array(
            Contest::CONTEST_VISIBILITY_PRIVATE => 'Tertutup',
            Contest::CONTEST_VISIBILITY_PUBLIC => 'Terbuka',
            Contest::CONTEST_VISIBILITY_CONDITIONED => 'Kondisi'
        );
    }

    public function isConditionSatisfied() {
        $user = Yii::app()->user->getRecord();
        $condition = eval($this->condition);
        return (($condition !== true) ? false : true);
    }

    public function isExpired() {
        $cur_time = time();
        $start_time = strtotime($this->start_time);
        $end_time = strtotime($this->end_time);

        if ($this->span_type == self::CONTEST_SPAN_TYPE_VIRTUAL && $this->isContestant(Yii::app()->user)) {
            $log = ContestLog::findFirstLog($this, Yii::app()->user, ContestLog::ACTION_ENTER);
            return (($log !== null) && (time() - $log->time > $this->getConfig('timespan') * 60)) || ($log === null) || !($start_time <= $cur_time && $end_time >= $cur_time);
        } else {
            return !($start_time <= $cur_time && $end_time >= $cur_time);
        }
    }

    public function getSecondsLeft() {
        if ($this->span_type == self::CONTEST_SPAN_TYPE_VIRTUAL && $this->isContestant(Yii::app()->user)) {
            $log = ContestLog::findFirstLog($this, Yii::app()->user, ContestLog::ACTION_ENTER);
            $retval = ($log->time + ($this->getConfig('timespan') * 60) - time());

            if ($log->time + ($this->getConfig('timespan') * 60) > strtotime($this->end_time))
                $retval = strtotime($this->end_time) - time();
        }
        else {
            $retval = strtotime($this->end_time) - time();
        }
        if ($retval < 0)
            $retval = 0;

        return $retval;
    }

    public function hasStarted() {
        $cur_time = time();
        $start_time = strtotime($this->start_time);
        return ($start_time <= $cur_time);
    }

    public function hasEnded() {
        $cur_time = time();
        $end_time = strtotime($this->end_time);
        return ($end_time < $cur_time);
    }

    public function isOwner($user) {
        return ($user->id == $this->owner_id) || ($user->id == 1);
    }

    public function isSupervisor($user) {
        return $this->checkRole($user, self::CONTEST_MEMBER_SUPERVISOR);
    }

    public function addSupervisor($user) {
        if (!$this->isOwner($user)) {
            $this->addMember($user, self::CONTEST_MEMBER_SUPERVISOR);
        }
    }

    public function removeSupervisor($user) {
        $this->removeMember($user, self::CONTEST_MEMBER_SUPERVISOR);
    }

    public function isContestant($user) {
        return $this->checkRole($user, self::CONTEST_MEMBER_CONTESTANT);
    }

    public function addContestant($user) {
        $this->addMember($user, self::CONTEST_MEMBER_CONTESTANT);
    }

    public function removeContestant($user) {
        $this->removeMember($user, self::CONTEST_MEMBER_CONTESTANT);
    }

    public function isRegistrant($user) {
        return $this->checkRole($user, self::CONTEST_MEMBER_REGISTRANT);
    }

    public function addRegistrant($user) {
        if (!$this->isRegistrant($user) && !$this->isMember($user)) {
            $this->addMember($user, self::CONTEST_MEMBER_REGISTRANT);
        }
    }

    public function removeRegistrant($user) {
        $this->removeMember($user, self::CONTEST_MEMBER_REGISTRANT);
    }

    public function addMember($user, $role) {
        $this->removeMember($user);
        //TODO: Fix this SQL
        $sql = "INSERT INTO contests_users (contest_id, user_id, role, register_date) VALUES ('" . $this->id . "', " . $user->id . ", " . $role . ", NOW());";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function removeMember($user, $role = NULL) {
        if ($role == NULL) {
            //TODO: Fix this SQL
            $sql = "DELETE FROM contests_users WHERE contest_id = '" . $this->id . "' AND user_id = '" . $user->id . "';";
        } else {
            //TODO: Fix this SQL
            $sql = "DELETE FROM contests_users WHERE contest_id = '" . $this->id . "' AND user_id = '" . $user->id . "' AND role = " . $role . ";";
        }
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function isMember($user) {
        return $this->isOwner($user) || $this->isSupervisor($user) || $this->isContestant($user);
    }

    public function checkRole($user, $role) {
        //TODO: Fix this SQL
        $sql = "SELECT user_id FROM contests_users WHERE contest_id = '" . $this->id . "' AND user_id = '" . $user->id . "' AND role = " . $role . ";";
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        return $result->rowCount > 0;
    }

    public function getRole($user) {
        if ($this->isOwner($user)) {
            return self::CONTEST_MEMBER_SUPERVISOR;
        } else {
            //TODO: Fix this SQL
            $sql = "SELECT role FROM contests_users WHERE contest_id = '" . $this->id . "' AND user_id = '" . $user->id . "';";
            $command = $this->dbConnection->createCommand($sql);
            $result = $command->query();
            if ($result->rowCount > 0) {
                $row = $result->read();
                return $row['role'];
            } else {
                return -1;
            }
        }
    }

    public function signUser($user, $page) {
        //TODO: Fix this SQL
        $sql = "UPDATE contests_users SET last_activity = NOW(), last_page = '$page' WHERE contest_id = '" . $this->id . "' AND user_id = '" . $user->id . "'";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function getLastActivity($user) {
        //TODO: Fix this SQL
        $sql = "SELECT last_activity, last_page FROM contests_users WHERE contest_id = '" . $this->id . "' AND user_id = '" . $user->id . "'";
        $command1 = $this->dbConnection->createCommand($sql);
        $result = $command1->query();
        $row = $result->read();
        if ($row == false) {
            return array('last_activity' => NULL, 'last_page' => NULL);
        } else {
            return $row;
        }
    }

    public function getMemberActivites() {
        //TODO Cache this
        $members = $this->members;
        $activities = array();
        foreach ($members as $member) {
            $ar = $this->getLastActivity($member);
            $activity = array(
                'id' => $member->id,
                'username' => $member->username,
                'full_name' => $member->full_name,
                'last_activity' => $ar['last_activity'],
                'last_page' => $ar['last_page']
            );
            $activities[] = $activity;
        }
        return $activities;
    }

    public function getACMICPCRanking($contestantonly = true, $nonhidden = false) {
        if ($nonhidden) {
            $problems = $this->nonhiddenproblems;
        } else {
            $problems = $this->problems;
        }
        if ($contestantonly) {
            $members = $this->contestants;
        } else {
            $members = $this->members;
            array_push($members, $this->owner);
        }
        $ranks = array();
        $aliases = $this->getProblemAliases();
        $statuses = $this->getProblemStatuses();
        $contest_id = $this->id;
        $countproblem = count($problems);
        $contest_start_time = strtotime($this->start_time);

        foreach ($members as $member) {
            $rank_row = array();
            $rank_row["submitter_id"] = $member->id;
            $rank_row["submitter_username"] = $member->username;
            $rank_row["submitter_full_name"] = $member->full_name;

            $total_ac = 0;
            $total_penalty = 0;

            foreach ($problems as $problem) {
                $problem_id = $problem->id;
                $submitter_id = $member->id;
                //if ($contestantonly){
                //    $submissions = Submission::model()->findAll(array(
                //        "condition" => "problem_id = $problem_id AND ".
                //                	   "submitter_id = $submitter_id AND ".
                //             	       "contest_id = $contest_id AND ".
                //					   "submitted_time < \"2010-09-25 14:00:00\"",
                //    	"order" => "submitted_time ASC"
                //	));
                //} else {
                $submissions = Submission::model()->findAll(array(
                    "condition" => "problem_id = $problem_id AND " .
                    "submitter_id = $submitter_id AND " .
                    "contest_id = $contest_id",
                    "order" => "submitted_time ASC"
                        ));
                //}
                $success = 0;
                $fail = 0;
                $trial = 0;
                $last_submit = 0;
                foreach ($submissions as $submission) {
                    $last_submit = $submission->submitted_time;
                    $trial++;

                    if ($submission->score == 0) {
                        $fail++;
                    } else {
                        $success++;
                        break;
                    }
                }

                $alias = $aliases[$problem->id];
                $rank_row["problem" . $alias . "_trial"] = $trial;
                if ($trial > 0)
                    $rank_row["problem" . $alias . "_submitted_time"] = ($trial - 1) * 1200 + strtotime($last_submit) - $contest_start_time;
                else
                    $rank_row["problem" . $alias . "_submitted_time"] = 0;
                $rank_row["problem" . $alias . "_accepted"] = $success != 0 ? 1 : 0;

                if ($success != 0) {
                    $total_ac++;
                    $total_penalty += $rank_row["problem" . $alias . "_submitted_time"];
                }
            }
            $rank_row['total_ac'] = $total_ac;
            $rank_row['total_penalty'] = $total_penalty;

            $ranks[] = $rank_row;
        }

        /* $ranks = array(
          array(
          "submitter_id" => "1",
          "problem1" => "",
          "problem2" => "",
          "problem3" => "",
          "problem4" => "",
          "acc_per_time" => ""
          ),
          array(
          "submitter_id" => "1",
          "problem1" => "",
          "problem2" => "",
          "problem3" => "",
          "problem4" => "",
          "acc_per_time" => ""
          ),

          ); */
        uasort($ranks, 'self::cmp');

        return $ranks;
    }

    private static function cmp($a, $b) {
        if ($a['total_ac'] > $b['total_ac'] || ($a['total_ac'] == $b['total_ac'] && $a['total_penalty'] < $b['total_penalty']))
            return -1;
        else
            return 1;
    }

    public function getRanking($contestantonly = true, $nonhidden = false) {
        //TODO Cache this
        if ($nonhidden) {
            $problems = $this->nonhiddenproblems;
        } else {
            $problems = $this->problems;
        }
        //var_dump($problems);
        if ($contestantonly) {
            $members = $this->contestants;
        } else {
            $members = $this->members;
            array_push($members, $this->owner);
        }
        $ranks = array();
        $aliases = $this->getProblemAliases();
        $statuses = $this->getProblemStatuses();
        $arscores = array();
        $lastsubmissions = Submission::getLastContestSubmissions($this);
        foreach ($lastsubmissions as $s) {
            $arscores[$s->submitter_id][$s->problem_id] = $s->score;
        }
        $rr = array();
        foreach ($members as $member) {
            $rank = array(
                'id' => $member->id,
                'username' => $member->username,
                'full_name' => $member->full_name,
            );
            $total = 0;
            foreach ($problems as $problem) {
                //echo $problem->title;
                $score = isset($arscores[$member->id][$problem->id]) ? $arscores[$member->id][$problem->id] : 0;
                $total = $total + $score;
                $rank['P' . $aliases[$problem->id]] = $score;
            }

            $rank['total'] = $total;
            $rank['rank'] = 0;
            $rr[] = $total;
            $ranks[] = $rank;
        }
        array_multisort($rr, SORT_DESC, $ranks);
        return $ranks;
    }

    public function getFullRanking($contestantonly = true, $nonhidden = false) {
        //TODO Cache this
        if ($nonhidden) {
            $problems = $this->nonhiddenproblems;
        } else {
            $problems = $this->problems;
        }
        //var_dump($problems);
        if ($contestantonly) {
            $members = $this->contestants;
        } else {
            $members = $this->members;
            array_push($members, $this->owner);
        }
        $ranks = array();
        $aliases = $this->getProblemAliases();
        $statuses = $this->getProblemStatuses();
        $arscores = array();
        $lastsubmissions = Submission::getLastContestSubmissions($this);
        foreach ($lastsubmissions as $s) {
            $arscores[$s->submitter_id][$s->problem_id] = $s->getGradeContent('official_result');
            //echo $s->grade_content . "\n";
        }
        $rr = array();
        foreach ($members as $member) {
            $rank = array(
                'id' => $member->id,
                'username' => $member->username,
                'full_name' => $member->full_name,
            );
            $total = 0;
            foreach ($problems as $problem) {
                //echo $problem->title;
                $score = isset($arscores[$member->id][$problem->id]) ? $arscores[$member->id][$problem->id] : 0;
                $total = $total + $score;
                $rank['P' . $aliases[$problem->id]] = $score;
            }

            $rank['total'] = $total;
            $rank['rank'] = 0;
            $rr[] = $total;
            $ranks[] = $rank;
        }
        array_multisort($rr, SORT_DESC, $ranks);
        return $ranks;
    }

    public function addProblem($problem) {
        //TODO: Fix this SQL
        $sql = "INSERT INTO contests_problems (contest_id, problem_id, status, timestamp) VALUES ('" . $this->id . "', " . $problem->id . ", " . self::CONTEST_PROBLEM_HIDDEN . ", NOW());";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
        $this->generateAliases();
    }

    public function removeProblem($problem) {
        //TODO: Fix this SQL
        $sql = "DELETE FROM contests_problems WHERE contest_id = '" . $this->id . "' AND problem_id = '" . $problem->id . "';";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
        $this->generateAliases();
    }

    public function generateAliases() {
        $table_name = 'contests_problems';
        $contest_id = $this->id;
        //TODO: Fix this SQL
        $sql1 = "SELECT problem_id FROM contests_problems WHERE contest_id = $contest_id ORDER BY timestamp ASC";
        $command1 = $this->dbConnection->createCommand($sql1);
        $problem_ids = $command1->query();
        $alias = 0;
        foreach ($problem_ids as $problem_id) {
            $alias++;
            $pid = $problem_id['problem_id'];
            $sql2 = "UPDATE contests_problems SET alias = $alias WHERE contest_id = $contest_id AND problem_id = $pid";
            $command2 = $this->dbConnection->createCommand($sql2);
            $command2->execute();
        }
    }

    public function getProblemByAlias($alias) {
        $aliases = $this->getProblemAliases();
        $aliases = array_flip($aliases);
        if (isset($aliases[$alias])) {
            $id = $aliases[$alias];
            $problem = Problem::model()->findByPk($id);
            return $problem;
        } else {
            return null;
        }
    }

    public function getProblemAlias($problem) {
        $aliases = $this->getProblemAliases();
        return $aliases[$problem->id];
    }

    public function getProblemAliases($nonhidden = false) {
        $contest_id = $this->id;
        if ($nonhidden) {
            //TODO: Fix this SQL
            $sql = "SELECT alias, problem_id FROM contests_problems WHERE contest_id = $contest_id AND status != " . self::CONTEST_PROBLEM_HIDDEN;
        } else {
            //TODO: Fix this SQL
            $sql = "SELECT alias, problem_id FROM contests_problems WHERE contest_id = $contest_id";
        }
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        $this->_aliases = array();
        foreach ($result as $r) {
            $this->_aliases[$r['problem_id']] = $r['alias'];
        }

        asort($this->_aliases);
        return $this->_aliases;
    }

    public function getProblemStatuses() {
        $contest_id = $this->id;
        $sql = "SELECT problem_id, status FROM contests_problems WHERE contest_id = $contest_id";
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        $this->_statuses = array();
        foreach ($result as $r) {
            $this->_statuses[$r['problem_id']] = $r['status'];
        }
        return $this->_statuses;
    }

    public function getProblemStatus($problem) {
        $statuses = $this->getProblemStatuses();
        return $statuses[$problem->id];
    }

    public static function getProblemStatusStrings() {
        $array = array(
            self::CONTEST_PROBLEM_HIDDEN => 'Hidden',
            self::CONTEST_PROBLEM_OPEN => 'Open',
            self::CONTEST_PROBLEM_CLOSED => 'Closed',
        );
        return $array;
    }

    public function getProblemStatusString($problem) {
        $array = self::getProblemStatusStrings();
        return $array[$this->getProblemStatus($problem)];
    }

    public function setProblemStatus($problem, $status) {
        $cid = $this->id;
        $pid = $problem->id;
        $sql = "UPDATE contests_problems SET status = $status WHERE contest_id = $cid AND problem_id = $pid";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function registerUser($user) {
        if ($this->status == Contest::CONTEST_VISIBILITY_PUBLIC) {
            $this->addContestant($user);
        } else if ($this->status == Contest::CONTEST_VISIBILITY_CONDITIONED) {
            $this->addRegistrant($user);
        }
    }

}

//end of file
