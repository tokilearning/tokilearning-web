<?php
/**
 *
 */
class Contest extends CActiveRecord {

    const CONTEST_VISIBILITY_HIDDEN = 0;
    const CONTEST_VISIBILITY_PUBLIC = 1;
    //
    const CONTEST_MEMBER_SUPERVISOR = 1;
    const CONTEST_MEMBER_CONTESTANT = 2;
    const CONTEST_MEMBER_INVITATION = 3;
    const CONTEST_MEMBER_OBSERVER = 4;
    //
    const CONTEST_PROBLEM_HIDDEN = 0;
    const CONTEST_PROBLEM_OPEN = 1;
    const CONTEST_PROBLEM_CLOSED = 2;

    public $startDate;
    public $startTime;
    public $endDate;
    public $endTime;
    public $_aliases;
    public $_statuses = null;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{contests}}';
    }
    
    public function relations(){
        return array(
            'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
            'members' => array(self::MANY_MANY, 'User', 'contests_users(contest_id, user_id)'),
            'supervisors' => array(self::MANY_MANY, 'User', 
                'contests_users(contest_id, user_id)',
                'condition' => 'role='.self::CONTEST_MEMBER_SUPERVISOR
                ),
            'contestants' => array(self::MANY_MANY, 'User',
                'contests_users(contest_id, user_id)',
                'condition' => 'role='.self::CONTEST_MEMBER_CONTESTANT
                ),
            'invitations' => array(self::MANY_MANY, 'User',
                'contests_users(contest_id, user_id)',
                'condition' => 'role='.self::CONTEST_MEMBER_INVITATION
                ),
            'observers' => array(self::MANY_MANY, 'User',
                'contests_users(contest_id, user_id)',
                'condition' => 'role='.self::CONTEST_MEMBER_OBSERVER
                ),
            'problems' => array(self::MANY_MANY, 'Problem',
                'contests_problems(contest_id, problem_id)'
                ),
            'openproblems' => array(self::MANY_MANY, 'Problem',
                'contests_problems(contest_id, problem_id)',
                'condition' => 'status='.self::CONTEST_PROBLEM_OPEN
                ),
            'nonhiddenproblems' => array(self::MANY_MANY, 'Problem',
                'contests_problems(contest_id, problem_id)',
                'condition' => 'status!='.self::CONTEST_PROBLEM_HIDDEN
                ),
        );
    }
    
    public function defaultScope(){
        return array('order'=>'start_time DESC, end_time DESC');
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Nama',
            'description' => 'Deskripsi',
            'start_time' => 'Waktu Mulai',
            'end_time' => 'Waktu Selesai',
            'owner_id' => 'Manajer'
        );
    }

    public function rules(){
        return array(
            array('name, description', 'required'),
            array('startDate, startTime, endDate, endTime, start_time, end_time', 'required', 'on' => 'create'),
            array('startDate, startTime, endDate, endTime, start_time, end_time', 'required', 'on' => 'update'),
            array('startDate, endDate', 'match', 'pattern' => '/^[0-9][0-9]\/[0-9][[0-9]\/[0-9][0-9][0-9][0-9]$/', 'on' => 'create'),
            array('startTime, endTime', 'match', 'pattern' => '/^[0-9][0-9]:[0-9][[0-9]$/', 'on' => 'create'),
        );
    }

    public function afterFind(){
        if ($this->start_time != null){
            $t = strtotime($this->start_time);
            $this->startDate = date('m/d/Y', $t);
            $this->startTime = date('H:i', $t);
        }
        if ($this->end_time != null){
            $t = strtotime($this->end_time);
            $this->endDate = date('m/d/Y', $t);
            $this->endTime = date('H:i', $t);
        }
        return parent::afterFind();
    }

    public function isExpired(){
        $cur_time = time();
        $start_time = strtotime($this->start_time);
        $end_time = strtotime($this->end_time);
        return !($start_time <= $cur_time && $end_time >= $cur_time);
    }

    public function hasStarted(){
        $cur_time = time();
        $start_time = strtotime($this->start_time);
        return ($start_time <= $cur_time);
    }

    public function hasEnded(){
        $cur_time = time();
        $end_time = strtotime($this->end_time);
        return ($end_time < $cur_time);
    }

    public function isOwner($user){
        return $user->id == $this->owner_id;
    }

    public function isSupervisor($user){
        $sql = "SELECT * FROM contests_users WHERE contest_id = '".$this->id."' AND user_id = '".$user->id."' AND role = ".self::CONTEST_MEMBER_SUPERVISOR.";";
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        return $result->rowCount > 0;
    }

    public function addSupervisor($user){
        if (!$this->isOwner($user)){
            $sql = "INSERT INTO contests_users (contest_id, user_id, role) VALUES ('".$this->id."', ".$user->id.", ".self::CONTEST_MEMBER_SUPERVISOR.");";
            $command = $this->dbConnection->createCommand($sql);
            $command->execute();
        }
    }

    public function removeSupervisor($user){
        $sql = "DELETE FROM contests_users WHERE contest_id = '".$this->id."' AND user_id = '".$user->id."' AND role = ".self::CONTEST_MEMBER_SUPERVISOR.";";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function isContestant($user){
        $sql = "SELECT * FROM contests_users WHERE contest_id = '".$this->id."' AND user_id = '".$user->id."' AND role = ".self::CONTEST_MEMBER_CONTESTANT.";";
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        return $result->rowCount > 0;
    }

    public function addContestant($user){
        $sql = "INSERT INTO contests_users (contest_id, user_id, role) VALUES ('".$this->id."', ".$user->id.", ".self::CONTEST_MEMBER_CONTESTANT.");";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function removeContestant($user){
        $sql = "DELETE FROM contests_users WHERE contest_id = '".$this->id."' AND user_id = '".$user->id."' AND role = ".self::CONTEST_MEMBER_CONTESTANT.";";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function isMember($user){
         return $this->isOwner($user) || $this->isSupervisor($user) || $this->isContestant($user);
    }

    public function getRole($user){
        if ($this->isOwner($user)){
            return self::CONTEST_MEMBER_SUPERVISOR;
        } else {
            $sql = "SELECT role FROM contests_users WHERE contest_id = '".$this->id."' AND user_id = '".$user->id."';";
            $command = $this->dbConnection->createCommand($sql);
            $result = $command->query();
            if ($result->rowCount > 0){
                $row = $result->read();
                return $row['role'];
            } else {
                return -1;
            }
        }
    }

    public function signUser($user, $page){
        $sql = "UPDATE contests_users SET last_activity = NOW(), last_page = '$page' WHERE contest_id = '".$this->id."' AND user_id = '".$user->id."'";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function getLastActivity($user){
        $sql = "SELECT last_activity, last_page FROM contests_users WHERE contest_id = '".$this->id."' AND user_id = '".$user->id."'";
        $command1 = $this->dbConnection->createCommand($sql);
        $result = $command1->query();
        $row = $result->read();
        if ($row == false){
            return array('last_activity' => NULL, 'last_page' => NULL);
        } else {
            return $row;
        }
    }

    public function getMemberActivites(){
        //TODO Cache this
        $members = $this->members;
        $activities = array();
        foreach($members as $member){
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

    public function getRanking($contestantonly = true, $nonhidden = false){
        //TODO Cache this
        if ($nonhidden){
            $problems = $this->nonhiddenproblems;
        } else {
            $problems = $this->problems;
        }
        if ($contestantonly){
            $members = $this->contestants;
        } else {
            $members = $this->members;
        }
        $ranks = array();
        $aliases = $this->getProblemAliases();
        $statuses = $this->getProblemStatuses();
        foreach($members as $member){
            $rank = array(
                'id' => $member->id,
                'username' => $member->username,
                'full_name' => $member->full_name,
            );
            $total = 0;
            foreach($problems as $problem){
                $score = 0;
                $rank['P'.$aliases[$problem->id]] = $score;
            }
            $rank['total'] = $total;
            $ranks[] = $rank;
        }
        return $ranks;
    }

    public function addProblem($problem){
        $sql = "INSERT INTO contests_problems (contest_id, problem_id, status, timestamp) VALUES ('".$this->id."', ".$problem->id.", ".self::CONTEST_PROBLEM_HIDDEN.", NOW());";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
        $this->generateAliases();
    }

    public function removeProblem($problem){
        $sql = "DELETE FROM contests_problems WHERE contest_id = '".$this->id."' AND problem_id = '".$problem->id."';";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
        $this->generateAliases();
    }

    public function generateAliases(){
        $table_name = 'contests_problems';
        $contest_id = $this->id;
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

    public function getProblemByAlias($alias){
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

    public function getProblemAlias($problem){
        $aliases = $this->getProblemAliases();
        return $aliases[$problem->id];
    }

    public function getProblemAliases($nonhidden = false){
        $contest_id = $this->id;
        if ($nonhidden){
            $sql = "SELECT alias, problem_id FROM contests_problems WHERE contest_id = $contest_id AND status != ".self::CONTEST_PROBLEM_HIDDEN;
        } else {
            $sql = "SELECT alias, problem_id FROM contests_problems WHERE contest_id = $contest_id";
        }
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        $this->_aliases = array();
        foreach($result as $r) {
            $this->_aliases[$r['problem_id']] = $r['alias'];
        }
        return $this->_aliases;
    }

    public function getProblemStatuses(){
        $contest_id = $this->id;
        $sql = "SELECT problem_id, status FROM contests_problems WHERE contest_id = $contest_id";
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        $this->_statuses = array();
        foreach($result as $r){
            $this->_statuses[$r['problem_id']] = $r['status'];
        }
        return $this->_statuses;
    }

    public function getProblemStatus($problem){
        $statuses = $this->getProblemStatuses();
        return $statuses[$problem->id];
    }

    public static function getProblemStatusStrings(){
        $array = array(
                self::CONTEST_PROBLEM_HIDDEN => 'Hidden',
                self::CONTEST_PROBLEM_OPEN => 'Open',
                self::CONTEST_PROBLEM_CLOSED => 'Closed',
        );
        return $array;
    }

    public function getProblemStatusString($problem){
        $array = self::getProblemStatusStrings();
        return $array[$this->getProblemStatus($problem)];
    }

    public function setProblemStatus($problem, $status){
        $cid = $this->id;
        $pid = $problem->id;
        $sql = "UPDATE contests_problems SET status = $status WHERE contest_id = $cid AND problem_id = $pid";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }
}
//end of file