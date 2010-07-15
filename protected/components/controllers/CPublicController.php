<?php

class CPublicController extends CCommonController {

    public function init() {
        parent::init();
        if (Yii::app()->user->isGuest) {
            $this->layout = 'application.views.layouts.static';
        } else {
            $this->layout = 'application.views.layouts.column2';
        }
    }

}