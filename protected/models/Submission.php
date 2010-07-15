<?php

//Yii::import("ext.evaluator.SubmissionEvaluator");

/**
 *
 */
class Submission extends CActiveRecord {

    const GRADE_STATUS_NOGRADE = -1;
    const GRADE_STATUS_PENDING = 0;
    const GRADE_STATUS_WAITING = 1;
    const GRADE_STATUS_ERROR   = 2;
    const GRADE_STATUS_GRADED  = 3;
    
    const RELEASE_LEVEL_BLIND = 0;
    const RELEASE_LEVEL_MEDIUM = 1;
    const RELEASE_LEVEL_EASY = 2;
    const RELEASE_LEVEL_FULL = 3;

    public $answer;
    private $_submitContent = array();
    private $_gradeContent = array();
    private $_lastGradeStatus;
    //private $evaluator;

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
    
    public function getReleaseLevel() {
        if ($this->contest === NULL) {
            return self::RELEASE_LEVEL_FULL;
        }
        else
            return $this->contest->getContestTypeHandler()->getReleaseLevel($this);
    }

    public function getEvaluator() {
        return $this->evaluator;
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
            'chapter' => array(self::BELONGS_TO, 'Chapter', 'chapter_id')
        );
    }

    public function isValid() {
        if ($this->getSubmitContent('source_lang') === null)
            return true;
        else
            return in_array($this->getSubmitContent('source_lang'), $this->problem->availableLanguages);
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
            if (!$this->isValid()) {
                throw new Exception("Format bahasa tidak didukung");
                return false;
            }
        }
        $this->submit_content = CJSON::encode($this->_submitContent);
        $this->grade_content = CJSON::encode($this->_gradeContent);
        return parent::beforeSave();
    }

    public function afterSave() {
        if ($this->grade_status !== self::GRADE_STATUS_GRADED) {
            $msgKey = Yii::app()->params->config['evaluator']['balancer']['message-key'];
            $msgType = Yii::app()->params->config['evaluator']['balancer']['message-type'];

            exec("sender " . $this->id . " " . $msgKey . " " . $msgType);
        }
        
        return parent::afterSave();
    }

    public function attributeLabels(){
        return array(
            'id' => 'ID',
            'problem_id' => Yii::t('labels', 'Soal'),
            'submitter_id' => Yii::t('labels', 'Pengumpul'),
            'submitted_time' => Yii::t('labels', 'Waktu Kumpul'),
            'grade_time' => Yii::t('labels', 'Waktu Periksa'),
            'grade_status' => Yii::t('labels', 'Status')
        );
    }

    public function rules(){
        return array(
            array('verdict, score, grade_status, comment', 'safe'),
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

    public static function getLastContestSubmissions($contest){
        $contest_id = $contest->id;

        $c = new CDbCriteria;
        $c->select = 'max(id) AS id';
        $c->condition = "contest_id = $contest_id GROUP BY submitter_id, problem_id";
        $s = self::model()->findAll($c);

        $submission_ids = array();
	$sids = array();
        foreach ($s as $sub) {
            //echo $sub->id . "<br />";
            $submission_ids[] = $sub->id;
	    $sids[$sub->id] = true;
        }

        $criteria = new CDbCriteria;
        $criteria->select = 'id, problem_id, submitter_id, verdict, score , grade_content , submit_content';
        $criteria->condition = "contest_id = $contest_id";

        $submissions = self::model()->findAll($criteria);
        $retval = array();

        foreach ($submissions as $submission) {
            //if (in_array($submission->id , $submission_ids)) {
	    if (isset($sids[$submission->id])) {
                $retval[] = $submission;
            }
        }

        //return self::model()->findAll($criteria);
        return $retval;
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
		$this->grade_content = array();
		$this->_gradeContent = array();
                $this->grade_time = null;
                $this->verdict = NULL;
                $this->score = 0;
                break;
            case  self::GRADE_STATUS_GRADED :
            case  self::GRADE_STATUS_ERROR :
                $this->grade_time = new CDbExpression('NOW()');
                break;
        }
    }

    public static function getPhantomSubmissions() {
        $submissions = Submission::model()->findAll("grade_status = " . Submission::GRADE_STATUS_PENDING);
        return $submissions;
    }
}
//end of file
