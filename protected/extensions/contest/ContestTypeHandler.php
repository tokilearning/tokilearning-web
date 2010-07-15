<?php

Yii::import("ext.contest.HandlerInterface");

abstract class ContestTypeHandler {

    public static $_handlers;
    public $controller;
    public $contestTypeName;
    protected $contest;

    public static function getHandler($param) {
        ///Imports
        $handlerClass = ucfirst($param->contesttype->name) . 'Handler';
        $handlerPath = 'ext.contest.types.' . $param->contesttype->name . '.' . $handlerClass;
        Yii::import($handlerPath);

        ///Instance
        $handler = new $handlerClass();
        $handler->contest = $param;

        //$class = __CLASS__;
        //$handler = new $class();
        //Settings
        $handler->contestTypeName = $param->contesttype->name;

        if (isset(Yii::app()->controller))
            $handler->controller = Yii::app()->controller;
        return $handler;
    }

    public function getContest() {
        return $this->contest;
    }

    public function getContestTypePathAlias() {
        return 'ext.contest.types.' . $this->contestTypeName;
    }

    public function install() {
        Yii::import($this->getContestTypePathAlias() . '.Installer');
        echo Installer::install();
    }

    public function initiate($contest) {
        Yii::import($this->getContestTypePathAlias() . '.Initiator');
        echo Initiator::init($contest, $this);
    }

    public function rankViewWidget($properties) {
        $this->controller->widget($this->getContestTypePathAlias() . '.widgets.' . ucfirst($this->contestTypeName) . 'RankViewWidget', $properties);
    }

    public function configurationWidget($properties) {
        $this->controller->widget($this->getContestTypePathAlias() . '.widgets.' . ucfirst($this->contestTypeName) . 'ConfigurationWidget', $properties);
    }
    
    public function getReleaseLevel($pSubmission) {
        return Submission::RELEASE_LEVEL_BLIND;
    }

    abstract public function getSupervisorMenu();

    abstract public function getContestantMenu();

    abstract public function getSupervisorMenuWidget($pIndex = 0);

    abstract public function getContestantMenuWidget($pIndex = 0);

    abstract public function beforeEvaluate($pContest, $pSubmission);

    abstract public function afterEvaluate($pContest, $pSubmission);

    abstract public function beforeEnter($pContest, $pUser);

    abstract public function afterEnter($pContest, $pUser);

    abstract public function beforeSubmit($pContest, $pSubmission);

    abstract public function afterSubmit($pContest, $pSubmission);

    abstract public function getContestLogText($pContestLog);

    abstract public function getContestLogRemarks($pContestLog);
    
    protected function cacheSubmissions($pSubmissions) {
        
    }
    
    public function clearSubmissionsCache() {
        
    }

    public function getSubmissionRemarks($pSubmission) {
        return "";
    }

}
