<?php

class EvaluatorLog extends CActiveRecord {
    
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{clarifications}}';
    }

    public function defaultScope(){
        return array('order'=>'id DESC',);
    }
}