<?php

class PasteBin extends CActiveRecord {
    const STATUS_PRIVATE= 0;
    const STATUS_PUBLIC = 1;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public static function getStatusStrings(){
        $strings = array(
            self::STATUS_PRIVATE => 'Private',
            self::STATUS_PUBLIC => 'Public'
        );
        return $strings;
    }

    public static function getTypes(){
        $types = array(
            'cpp' => 'C++',
            'c' => 'C',
            'java' => 'Java',
            'pascal' => 'Pascal',
            'text' => 'Text'
        );
        return $types;
    }

    public static function getScript($type){
        $scripts = array(
            'cpp' => 'shBrushCpp.js',
            'c' => 'shBrushCpp.js',
            'java' => 'shBrushJava.js',
            'pascal' => 'shBrushDelphi.js',
            'text' => 'shBrushPlain.js'
        );
        return $scripts[$type];
    }

    public function tableName() {
        return '{{pastebin}}';
    }

    public function getStatus(){
        $strings = self::getStatusStrings();
        return $strings[$this->status];
    }

    

    public function relations(){
        return array(
            'owner' => array(self::BELONGS_TO, 'User', 'owner_id')
        );
    }

    public function defaultScope(){
        return array('order'=>'created_date DESC',);
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'owner_id' => 'Owner',
            'type' => 'Tipe',
            'status' => 'Status'
        );
    }

    public function rules(){
        return array(
            array('content, status, type', 'required'),
        );
    }

    public function beforeSave(){
        if ($this->isNewRecord) {
            $this->created_date = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }
}