<?php

class TestController extends CSupervisorController {

    public function actionIndex() {
        $this->layout = 'application.views.layouts.column1l31r';
        //$statistics = StatisticsHandler::instance();
        //$statistics->computeStatistics();
        $this->render('index');
    }

}
