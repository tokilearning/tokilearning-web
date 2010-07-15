<?php

class ProblemTypeHandler {

    public static $_handlers;

    public $controller;
    public $problemTypeName;

    public static function getHandler($param){
        $problemtype = '';
        if ($param instanceof Submission){
            $problemtype = $param->problem->problemtype->name;
        } else if ($param instanceof Problem){
            $problemtype = $param->problemtype->name;
        } else if ($param instanceof ProblemType){
            $problemtype = $param->name;
        } else if (is_string($param)){
            $problemtype = $param;
        }
        
        if (!isset($_handlers[$problemtype]) || ($_handlers[$problemtype])) {
            $class =__CLASS__;
            $handler = new $class();
            $handler->problemTypeName = $problemtype;
            $handler->controller = Yii::app()->controller;
            $_handlers[$problemtype] = $handler;
        }
        return $_handlers[$problemtype];
    }

    public function getProblemTypePathAlias(){
        return 'ext.evaluator.types.'.$this->problemTypeName;
    }

    public function problemViewWidget($properties){
        $this->controller->widget($this->getProblemTypePathAlias().'.widgets.'.ucfirst($this->problemTypeName).'ProblemViewWidget', $properties);
    }

    public function problemUpdateWidget($properties){
        $this->controller->widget($this->getProblemTypePathAlias().'.widgets.'.ucfirst($this->problemTypeName).'ProblemUpdateWidget', $properties);
    }

    public function problemSubmitWidget($properties){

    }

    public function submissionViewWidget($properties){
        $this->controller->widget($this->getProblemTypePathAlias().'.widgets.'.ucfirst($this->problemTypeName).'SubmissionViewWidget', $properties);
    }

    public function submissionUpdateWidget($properties){
        $this->controller->widget($this->getProblemTypePathAlias().'.widgets.'.ucfirst($this->problemTypeName).'SubmissionUpdateWidget', $properties);
    }

    public function initializeProblem($problem){
        $handlerclass = ucfirst($this->problemTypeName).'Handler';
        $handlerpath = $this->getProblemTypePathAlias().'.'.$handlerclass;
        Yii::import($handlerpath);
        $handlerclass::initializeProblem($problem);
    }
    
}
