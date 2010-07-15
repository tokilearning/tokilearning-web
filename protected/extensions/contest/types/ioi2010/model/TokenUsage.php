<?php

class TokenUsage extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{token_usages}}';
    }

    public function relations() {
        return array(
            'contest' => array(self::BELONGS_TO, 'Contest', 'contest_id'),
            'contestant' => array(self::BELONGS_TO, 'User', 'contestant_id'),
            'problem' => array(self::BELONGS_TO, 'Problem', 'problem_id'),
        );
    }
    
    public static function findFix($contest , $contestant , $problem) {
        return TokenUsage::model()->find(array(
            'condition' => "contest_id = $contest->id AND contestant_id = $contestant->id AND problem_id = $problem->id"
        ));
    }
    
    public static function findByContestContestant($contest , $contestant) {
        return TokenUsage::model()->findAll(array(
            'condition' => "contest_id = $contest->id AND contestant_id = $contestant->id"
        ));
    }
    
    public function rules() {
        return array(
            array('contest_id, problem_id, contestant_id', 'required')
        );
    }
    
    public function useToken() {
        $retval = false;
        $this->amount--;
        if ($this->amount < 0) {
            $this->amount = 0;
            $retval = false;
        }
        else
            $retval = true;
        $this->save();
        return $retval;
    }
    
    public function updateAmount($regenTime) {
        //TODO: fix this!
        $previousSubmissions = Submission::model()->findAll(array(
            'condition' => "contest_id = " . $this->contest_id . " AND submitter_id = " . $this->contestant_id . " AND problem_id = " . $this->problem_id . " AND TIMESTAMPDIFF(minute , submitted_time , NOW()) <= " . $regenTime
        ));
        $contest = Contest::model()->findByPK($this->contest_id);
        $usage = 0;
        foreach ($previousSubmissions as $s) {
            if ($s->getSubmitContent('fullfeedback'))
                $usage++;
        }
        echo $usage;
        $this->amount = $contest->getConfig('max_token') - $usage;
        $this->save();
    }
    
    public static function findByContest($contest) {
        return TokenUsage::model()->findAll(array(
            'criteria' => "contest_id = $contest->id"
        ));
    }

}

?>
