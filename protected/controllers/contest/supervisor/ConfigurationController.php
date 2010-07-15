<?php

class ConfigurationController extends CContestController {

    public $layout = 'application.views.layouts.contestsupervisor';
    public $defaultAction = 'contest';
    
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
    public function actionContest() {
        $model = $this->getContest();
        if (isset($_POST['Contest'])){
            $model->setScenario('update');
            $model->attributes = $_POST['Contest'];
            $model->attributes = $_POST['Contest'];
            $model->start_time = date('Y-m-d H:i:s', strtotime($model->startDate." ".$model->startTime.":00"));
            $model->end_time = date('Y-m-d H:i:s', strtotime($model->endDate." ".$model->endTime).":00");
            if ($model->validate()){
                $model->save(false);
                $this->redirect(array('contest'));
            }
        }
        $this->render('contest', array('model' => $model));
    }
}
