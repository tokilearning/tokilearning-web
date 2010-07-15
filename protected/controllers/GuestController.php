<?php

/**
 *
 */
class GuestController extends CGuestController {

    public $layout = 'application.views.layouts.guest';

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            )
        );
    }

    public function actionIndex() {
        $loginform = new LoginForm;
        $user = new User('register');
        $reghasError = false;
        if (isset($_POST['User'])) {
            $user->attributes=$_POST['User'];
            if($user->validate()){
                $realpassword = $user->password;
                $user->password = sha1($user->password);
                if ($user->save(false)){
                    $group = Group::model()->findbyAttributes(array('name' => 'learner'));
                    if($group != null){
                        Yii::app()->authManager->assign($group->name, $user->id);
                        $group->addMember($user);
                    }
                    $identity = new UserIdentity($user->username, $realpassword);
                    $identity->authenticate();
                    Yii::app()->user->login($identity);
                    $this->redirect(array('/home'));
                }
            } else {
                $reghasError = true;
            }
        }
        $this->render('index',
                array(
                    'loginform' => $loginform,
                    'user' => $user,
                    'regHasError' => $reghasError,
                )
        );
    }

    public function actionSignin() {
        $this->layout = 'application.views.layouts.guest';
        $form = new LoginForm;
        if (isset($_POST['LoginForm'])) {
            $form->attributes = $_POST['LoginForm'];
            if (!$form->validate()) {

            } else {
                if ($form->rememberMe) {
                    Yii::app()->user->login($form->identity, 3600 * 24 * 7);
                } else {
                    Yii::app()->user->login($form->identity);
                }
                $this->redirect(array('/home'));
            }
        }
        $this->render('signin', array('form' => $form));
    }

    public function actionForgot() {
        if ($_POST && isset($_POST['forgot'])){
            $username = $_POST['forgot'];
            $user = User::findbyUsernameEmail($username);
            if ($user != null){
                $user->generateActivationCode();
                Yii::app()->user->setFlash('forgot', 'success');
            } else {
                Yii::app()->user->setFlash('forgot', 'failed');
            }
        }
        $this->render('forgot');
    }

    public function actionChangePassword(){
        if(isset($_GET['user']) && isset($_GET['key'])){
            $user = User::findbyUsernameEmail($_GET['user']);
            if ($user == null || $user->activation_code != $_GET['key']){
                $this->render('changepassword1', array('error' => true));
            } else {
                if (isset($_POST['User'])){
                    $user->setScenario('forgotpassword');
                    $user->attributes = $_POST['User'];
                    if ($user->validate()){
                        $realpassword = $user->password;
                        $user->password = sha1($user->password);
                        $user->activation_code = null;
                        if ($user->save(false)){
                            $identity = new UserIdentity($user->username, $realpassword);
                            $identity->authenticate();
                            Yii::app()->user->login($identity);
                            $this->redirect(array('/home'));
                        }
                    } else {
                        $this->render('changepassword2', array('user' => $user));
                    }
                } else {
                    $this->render('changepassword2', array('user' => $user));
                }
            }
        } else {
            $this->render('changepassword1');
        }
    }

}