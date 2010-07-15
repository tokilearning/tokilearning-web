<?php

class SystemController extends CAdminController {

    public $layout = 'application.views.layouts.column2';
    public $defaultAction = 'phpinfo';
    public $pageTitle = 'Sistem';

    public function actionPHPInfo() {
        $this->render('phpinfo');
    }

}