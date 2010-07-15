<?php

/**
 *
 */
class MailerController extends CAdminController {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionCreate(){
        $this->render('create');
    }

}