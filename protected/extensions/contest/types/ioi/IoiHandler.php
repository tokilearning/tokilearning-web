<?php

Yii::import("ext.contest.ContestTypeHandler");

//Yii::import("ext.contest.HandlerInterface");

class IoiHandler extends ContestTypeHandler /* implements HandlerInterface */ {

    public function getSupervisorMenu() {
        return array();
    }

    public function getContestantMenu() {
        return array();
    }

    public function getContestLogText($pContestLog) {
        
    }

    public function getContestLogRemarks($pContestLog) {
        
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
        ContestLog::submitSolution($pSubmission->submitter_id, $pContest->id, $pSubmission->id);
    }

}
