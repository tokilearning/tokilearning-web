<?php

class LogController extends CAdminController {

    public $defaultAction = 'evaluator';
    
    public function actionEvaluator(){
        $this->render('evaluator');
    }
}