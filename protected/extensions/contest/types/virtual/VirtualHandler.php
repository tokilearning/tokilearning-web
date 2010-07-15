<?php

Yii::import("ext.contest.ContestTypeHandler");

//Yii::import("ext.contest.HandlerInterface");

class VirtualHandler extends ContestTypeHandler /* implements HandlerInterface */ {

    public function getSupervisorMenu() {
        return array();
    }

    public function getContestantMenu() {
        return array();
    }

    public function getSupervisorMenuWidget($pIndex = 0) {
        
    }

    public function getContestantMenuWidget($pIndex = 0) {
        
    }

    public function beforeEvaluate($pContest, $pSubmission) {
        
    }

    public function afterEvaluate($pContest, $pSubmission) {
        
    }

    public function beforeEnter($pContest, $pUser) {
        
    }

    public function afterEnter($pContest, $pUser) {
        
    }

    public function beforeSubmit($pContest, $pSubmission) {
        
    }

    public function afterSubmit($pContest, $pSubmission) {
        
    }

    public function getContestLogRemarks($pContestLog) {
        
    }

    public function getContestLogText($pContestLog) {
        
    }

}
