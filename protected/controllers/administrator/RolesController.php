<?php

class RolesController extends CAdminController {

    public $defaultAction = 'list';

    public function actionList() {
        $auth = Yii::app()->authManager;
        $roles = $auth->getRoles();
        $this->render('list', array('roles' => $roles));
    }

}