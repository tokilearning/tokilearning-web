<?php

class CGuestController extends CController {

    public function init() {
        if (Yii::app()->user->checkAccess("@")) {
            $this->redirect('home');
        }
    }

}