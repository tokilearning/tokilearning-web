<?php

/**
 *
 */
class AccountController extends CMemberController {

    public function actionRegister() {
        
    }

    public function actionSetting() {
        $model = User::model()->findByPk(Yii::app()->user->getId());
        $model->setScenario('setting');
        $originalpassword = $model->password;
        if (isset($_POST['User'])){
            $model->attributes = $_POST['User'];
            if (strlen($model->password) == 0){
                $model->password = $originalpassword;
            }
            if ($model->validate()){
                $model->password = sha1($model->password);
                $model->save(false);
                $this->redirect(array('/home'));
            }
        }
        $model->password = '';
        $this->render('setting', array('model' => $model));
    }

    public function actionSignOut() {
        Yii::app()->user->logout();
        $this->redirect(array('/guest'));
    }

}