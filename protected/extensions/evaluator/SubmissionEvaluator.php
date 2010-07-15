<?php

class SubmissionEvaluator {
    public static $_evaluators;
    public $problemTypeName;
    private $concreteEvaluator;
    
    public static function getEvaluator($param){
        $problemtype = '';
        if ($param instanceof Submission){
            $problemtype = $param->problem->problemtype->name;
        } else {
            throw new Exception("Unknown problem type");
        }

        if (!isset($_evaluators[$problemtype]) || ($_evaluators[$problemtype])) {
            $evaluator = new SubmissionEvaluator($param , $problemtype);
            $_evaluators[$problemtype] = $evaluator;
            //echo $problemtype;
        }
        
        return $_evaluators[$problemtype];
    }
    
    public function __construct($submission , $problemTypeName) {
        $this->problemTypeName = $problemTypeName;
        $evaluatorclass = ucfirst($this->problemTypeName).'Evaluator';
        $evaluatorpath = $this->getProblemTypePathAlias().'.'.$evaluatorclass;
        Yii::import($evaluatorpath);
        $this->concreteEvaluator = new $evaluatorclass($submission);
    }

    public static function getClusterEvaluator($problemtype) {
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
        //$evaluatorclass = ucfirst($this->problemTypeName).'Evaluator';
        //$evaluatorpath = $this->getProblemTypePathAlias().'.'.$evaluatorclass;
        //Yii::import($evaluatorpath);
        //$evaluatorclass::evaluate($submission);
        //call_user_func(array($evaluatorclass , 'evaluate') , $submission);
        $this->concreteEvaluator->doEvaluate();
    }
    
    public function getConcreteEvaluator() {
        return $this->concreteEvaluator;
    }

    public function evaluateCluster($submission , $problem , $problemtype) {
        $evaluatorclass = ucfirst($this->problemTypeName).'Evaluator';
        $evaluatorpath = $this->getProblemTypePathAlias().'.'.$evaluatorclass;
        Yii::import($evaluatorpath);
        call_user_func_array(array($evaluatorclass , 'evaluateCluster') , array($submission , $problem , $problemtype));
    }

    public function evaluateClusterResult($pSubmission , $pResult) {
        $evaluatorclass = ucfirst($this->problemTypeName).'Evaluator';
        $evaluatorpath = $this->getProblemTypePathAlias().'.'.$evaluatorclass;
        Yii::import($evaluatorpath);
        call_user_func_array(array($evaluatorclass , 'evaluateClusterResult') , array($pSubmission , $pResult));
    }
}