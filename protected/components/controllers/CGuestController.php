<?php

class CGuestController extends CCommonController {

    public function init() {
        parent::init();
        if (Yii::app()->user->checkAccess("@")) {
            $this->redirect('home');
        }
    }

}