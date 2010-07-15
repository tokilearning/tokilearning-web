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
        $originalfullname = $model->full_name;
		$originalusername = $model->username;
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->isDummy()) {
                $model->full_name = $originalfullname;
				$model->username = $originalusername;
            }
            if (strlen($model->password) == 0) {
                $model->password = $originalpassword;
            }
            if ($model->validate()) {
                $model->save(false);
                Yii::app()->user->setFlash('accountUpdateSuccess', true);
                $this->redirect(array('setting'));
            }
        }
        $model->password = '';
        $this->render('setting', array('model' => $model));
    }

    public function actionSignOut() {
        Yii::app()->user->logout();
        $this->redirect(array('/guest'));
    }

    public function actionUpdateGeneral() {
        $model = User::model()->findByPk(Yii::app()->user->getId());
        $model->setScenario('updateGeneral');
        if (isset($_POST['User'])) {
            $model->setAttributes($_POST['User']);
            if ($model->validate()) {
                $model->save(false);
                Yii::app()->user->setFlash('accountInformationUpdateSuccess', true);
                $this->redirect(array('setting'));
            } else {
                //var_dump($model->errors);
            	//exit;
            	//$this->render('setting', array('model' => $model));
            	$this->redirect(array('setting'));
			}
        } else {
            $this->redirect(array('setting'));
        }
    }

    public function actionStatistics(){        
        $this->render('statistics');
    }

}
