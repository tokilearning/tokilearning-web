<?php

/**
 * 
 */
class ProfileController extends CMemberController {

    public $layout = 'application.views.layouts.column2';
    public $defaultAction = 'view';

    public function actionView() {
        if (isset($_GET['id'])) {
            $user = User::model()->findByPk($_GET['id']);
            if ($user != null) {
                $this->render('view', array('user' => $user));
            } else {
                throw new CHttpException(404, 'Pengguna tidak dapat ditemukan');
            }
        } else {
            //show this users
        }
    }

}