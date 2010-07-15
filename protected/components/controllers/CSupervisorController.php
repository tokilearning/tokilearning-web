<?php

class CSupervisorController extends CCommonController {

    public $layout = 'application.views.layouts.column2';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'roles' => array('supervisor'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

}