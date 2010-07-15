<?php

class MenuController extends CContestController {

    public $layout = 'application.views.layouts.contestsupervisor';
    private $_model;

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
}