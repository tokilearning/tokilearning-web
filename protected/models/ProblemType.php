<?php

class ProblemType extends CActiveRecord {

    private static $problemTypeRepositoryPath;
    private $_config;
    
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{problem_types}}';
    }

    public static function toArray(){
        $types = self::model()->findAll();
        $array = array();
        foreach($types as $type){
            $array[$type->id] = $type->name;
        }
        return $array;
    }

    public function init(){
        self::$problemTypeRepositoryPath = Yii::app()->params->config['evaluator']['problem']['problem_type_repository_path']."/";
    }

    public function afterFind(){
        $config_content = file_get_contents($this->getEvaluatorConfigPath());
        $this->_config = CJSON::decode($config_content);
        parent::afterFind();
    }

    public function getConfigs(){
        return $this->_config;
    }

    public function getConfig($name){
        $var = $this->_config[$name];
        if (isset($var)){
            return $var;
        } else {
            return null;
        }
    }

    public function getDirectoryPath(){
        return self::$problemTypeRepositoryPath.$this->name.'/';
    }

    public function getViewDirectoryPath(){
        return $this->getDirectoryPath().'view/';
    }

    public function getEvaluatorDirectoryPath(){
        return $this->getDirectoryPath().'evaluator/';
    }

    public function getEvaluatorConfigPath(){
        return $this->getEvaluatorDirectoryPath().'config.json';
    }

    public function getEvaluatorScriptPath(){
        return $this->getEvaluatorDirectoryPath().'evaluator.php';
    }
}