<?php

class ContestType extends CActiveRecord {

    private $_config;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{contest_types}}';
    }

    public static function toArray() {
        $types = self::model()->findAll();
        $array = array();
        foreach ($types as $type) {
            $array[$type->id] = $type->name;
        }
        return $array;
    }

    public function afterFind() {
        //TODO:
        parent::afterFind();
    }

    public function getConfigs() {
        return $this->_config;
    }

    public function getConfig($name) {
        $var = $this->_config[$name];
        if (isset($var)) {
            return $var;
        } else {
            return null;
        }
    }

    public static function getHandler($contest) {
        Yii::import('ext.contest.ContestTypeHandler');
        return ContestTypeHandler::getHandler($contest);
    }

}