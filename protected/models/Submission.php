<?php

/**
 *
 */
class Submission extends CActiveRecord {

    const GRADE_STATUS_NOGRADE = -1;
    const GRADE_STATUS_PENDING = 0;
    const GRADE_STATUS_WAITING = 1;
    const GRADE_STATUS_ERROR   = 2;
    const GRADE_STATUS_GRADED  = 3;

    public $answer;
    private $_submitContent = array();
    private $_gradeContent = array();
    private $_lastGradeStatus;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public static function getFirstPending(){
        return self::model()->firstpending()->find();
    }

    public static function getGradeStatuses(){
        $a = array(
            self::GRADE_STATUS_NOGRADE => "no grade",
            self::GRADE_STATUS_PENDING => "pending",
            self::GRADE_STATUS_WAITING => "waiting",
            self::GRADE_STATUS_ERROR => "error",
            self::GRADE_STATUS_GRADED => "graded"
        );
        return $a;
    }

    public function tableName() {
        return '{{submissions}}';
    }

    public function defaultScope(){
        return array('order'=>'submitted_time DESC, grade_time DESC');
    }

    public function relations(){
        return array(
            'problem' => array(self::BELONGS_TO, 'Problem', 'problem_id'),
            'contest' => array(self::BELONGS_TO, 'Contest', 'contest_id'),
            'submitter' => array(self::BELONGS_TO, 'User', 'submitter_id'),
        );
    }

    public function afterFind(){
        $this->_submitContent = CJSON::decode($this->submit_content);
        $this->_gradeContent = CJSON::decode($this->grade_content);
        $this->_lastGradeStatus = $this->grade_status;
        return parent::afterFind();
    }

    public function beforeSave(){
        if ($this->isNewRecord) {
            $this->submitted_time = new CDbExpression('NOW()');
        }
        $this->submit_content = CJSON::encode($this->_submitContent);
        $this->grade_content = CJSON::encode($this->_gradeContent);
        return parent::beforeSave();
    }

    public function attributeLabels(){
        return array(
            'id' => 'ID',
            'problem_id' => 'Soal',
            'submitter_id' => 'Pengumpul',
            'submitted_time' => 'Waktu Kumpul',
            'grade_time' => 'Waktu Periksa',
            'grade_status' => 'Status'
        );
    }

    public function scopes(){
        return array(
            'firstpending' => array(
                'condition' => 'grade_status = '.self::GRADE_STATUS_PENDING,
                'with' => array(
                    'problem' => array(
                        'select' => array('id', 'title', 'problem_type_id', 'token')
                    ),
                    'problem.problemtype' => array(
                        'select' => array('id', 'name')
                    )
                ),
                'order' => 't.id ASC'
            )
        );
    }

    public function setSubmitContent($name, $value){
        $this->_submitContent[$name] = $value;
    }

    public function getSubmitContent($name){
        $var = $this->_submitContent[$name];
        if (isset($var)) {
            return $var;
        } else {
            return null;
        }
    }

    public function setGradeContent($name, $value){
        $this->_gradeContent[$name] = $value;
    }

    public function getGradeContent($name){
        $var = $this->_gradeContent[$name];
        if (isset($var)) {
            return $var;
        } else {
            return null;
        }
    }

    public function getGradeStatus(){
        $r = self::getGradeStatuses();
        return ucwords($r[$this->grade_status]);
    }

    public function setGradeStatus($grade_status){
        $this->grade_status = $grade_status;
        switch($grade_status){
            case self::GRADE_STATUS_NOGRADE :
            case self::GRADE_STATUS_WAITING :
            case self::GRADE_STATUS_PENDING :
                $this->grade_time = null;
                break;
            case  self::GRADE_STATUS_GRADED :
            case  self::GRADE_STATUS_ERROR :
                $this->grade_time = new CDbExpression('NOW()');
                break;
        }
    }
}
//end of file