<?php

class Clarification extends CActiveRecord {

    const STATUS_UNANSWERED = 0;
    const STATUS_ANSWERED = 1;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{clarifications}}';
    }

    public function defaultScope(){
        return array('order'=>'questioned_time DESC, answered_time DESC');
    }

    public function relations() {
        return array(
            'contest' => array(self::BELONGS_TO, 'Contest', 'contest_id'),
            'questioner' => array(self::BELONGS_TO, 'User', 'questioner_id'),
            'answerer' => array(self::BELONGS_TO, 'User', 'answerer_id'),
            'problem' => array(self::BELONGS_TO, 'Problem', 'problem_id'),
            'contest' => array(self::BELONGS_TO, 'Contest', 'contest_id'),
        );
    }

    public function attributeLabels(){
        return array(
            'questioner_id' => 'Questioner',
            'problem_id' => 'Problem'
        );
    }

    public function rules(){
        return array(
            array('subject, question', 'required', 'on' => 'create'),
            array('answer', 'required', 'on' => 'answer')
        );
    }

    public function beforeSave(){
        if ($this->isNewRecord) {
            $this->questioned_time = new CDbExpression('NOW()');
            $this->status = self::STATUS_UNANSWERED;
        }
        $this->question = strip_tags($this->question, '<b><i><u><a>');
        $this->answer = strip_tags($this->answer, '<b><i><u><a>');
        return parent::beforeSave();
    }

    public static function getStatusStrings(){
        return array(
            self::STATUS_UNANSWERED => 'Unanswered',
            self::STATUS_ANSWERED => 'Answered',
        );
    }

    public function getStatus(){
        $array = self::getStatusStrings();
        return $array[$this->status];
    }
}