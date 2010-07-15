<?php

class StatisticsController extends CContestController {

    public $layout = 'application.views.layouts.contestsupervisor';
    public $defaultAction = 'activity';
    
    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'expression' => 'Yii::app()->controller->isSupervisor()'
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $this->render('index');
    }

    public function actionRank(){
        //TODO: Cache this
        $ranks = $this->getContest()->getRanking();
        $dataProvider = new ArrayDataProvider($ranks, array(
            'pagination' => 30
        ));
        if (isset($_GET['zoom']) && $_GET['zoom'] == 'zoom'){
            $this->layout = 'application.views.layouts.column1';
            $this->render('rank_zoom', array('dataProvider' => $dataProvider));
        } else {
            $this->render('rank', array('dataProvider' => $dataProvider));
        }
    }

    public function actionDownloadRank(){
        header('Content-type: text/csv');
        $date = date('YmdHis', time());
        header('Content-Disposition: attachment; filename="ranks-'.$date.'.csv"');
        $ranks = $this->getContest()->getRanking();
        $this->renderPartial('csv/rank', array('ranks' => $ranks));
    }

    public function actionActivity(){
        $activities = $this->getContest()->getMemberActivites();
        $dataProvider = new ArrayDataProvider($activities, array(
            'pagination' => 30
        ));
        $this->render('activity', array('dataProvider' => $dataProvider));
    }

    public function actionDownloadActivity(){
        header('Content-type: text/csv');
        $date = date('YmdHis', time());
        header('Content-Disposition: attachment; filename="activities-'.$date.'.csv"');
        $activities = $this->getContest()->getMemberActivites();
        $this->renderPartial('csv/activity', array('activities' => $activities));
    }

}
