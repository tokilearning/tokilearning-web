<?php

class RankController extends CContestController {

    public function actionIndex() {
        /*if ($this->getContest()->contest_type_id == 1) {
            $ranks = $this->getContest()->getRanking(true, true);
        } else {
            $ranks = $this->getContest()->getACMICPCRanking(true, true);
        }*/
        $this->render('index', array('ranks' => $ranks));
    }

}
