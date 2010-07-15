<?php

class ErrorController extends Controller {

    public $layout = 'application.views.layouts.guest';

    public function actionIndex() {
        if ($error = Yii::app()->errorHandler->error) {
            $this->render('index', $error);
        }
    }

}