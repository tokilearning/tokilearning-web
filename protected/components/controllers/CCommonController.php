<?php

class CCommonController extends CController {

    public $widgets;  

    public function addWidget($location, $class, $properties = array()) {
        $this->widgets[$location][$class] = $properties;
    }

    public function init(){
        if (!Yii::app()->user->isGuest){
            $record = Yii::app()->user->updateLastActivity();
        }
    }

    public function printWidgets($location) {
        if (isset($this->widgets) && isset($this->widgets[$location]) && is_array($this->widgets[$location])) {
            foreach($this->widgets[$location] as $class => $properties){
                $this->widget($class, $properties);
            }
        }
    }

}