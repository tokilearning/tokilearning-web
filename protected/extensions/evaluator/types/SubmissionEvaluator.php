<?php

class SubmissionEvaluator {
    public static $_evaluators;
    public $problemTypeName;
    
    public static function getEvaluator($param){
        $problemtype = '';
        if ($param instanceof Submission){
            $problemtype = $param->problem->problemtype->name;
        } else {
            throw new Exception("Unknown problem type");
        }

        if (!isset($_evaluators[$problemtype]) || ($_evaluators[$problemtype])) {
            $class =__CLASS__;
            $evaluator = new $class();
            $evaluator->problemTypeName = $problemtype;
            $_evaluators[$problemtype] = $evaluator;
        }
        return $_evaluators[$problemtype];
    }

    public function getProblemTypePathAlias(){
        return 'ext.evaluator.types.'.$this->problemTypeName;
    }

    public function evaluate($submission){
        $evaluatorclass = ucfirst($this->problemTypeName).'Evaluator';
        $evaluatorpath = $this->getProblemTypePathAlias().'.'.$evaluatorclass;
        Yii::import($evaluatorpath);
        $evaluatorclass::evaluate($submission);
    }
}