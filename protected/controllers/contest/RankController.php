<?php

class RankController extends CContestController {

    public function actionIndex() {
        $ranks = $this->getContest()->getRanking(true, true);
        $dataProvider = new ArrayDataProvider($ranks, array(
            'pagination' => 30
        ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

}
