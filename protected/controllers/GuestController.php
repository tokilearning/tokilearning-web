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
            $user->attributes = $_POST['User'];
            if ($user->validate()) {
                $realpassword = $user->password;
                if ($user->save(false)) {
                    $this->sendRegisterMail($user);
                    $group = Group::model()->findbyAttributes(array('name' => 'learner'));
                    if ($group != null) {
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
        
        $dataProvider = new CActiveDataProvider('Announcement', array(
            'criteria'=>array(
                'condition' => 'status = :status',
                'params'=>array(
                    'status' => ContestNews::STATUS_PUBLISHED,
                ),
                'with'=>array('author'),
            ),
            'pagination'=>array(
                'pageSize'=>2,
            ),
        ));
        
        $this->render('index',
                array(
                    'loginform' => $loginform,
                    'user' => $user,
                    'regHasError' => $reghasError,
                    'dataProvider' => $dataProvider,
                )
        );
    }

    public function actionSignup(){
        $this->layout = 'application.views.layouts.guest';
        
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
    
    public function actionAppSignin() {
        $form = new LoginForm();
        if (isset($_POST['LoginForm'])) {
            $form->attributes = $_POST['LoginForm'];
            if ($form->validate()) {
                Yii::app()->user->login($form->identity, 3600 * 24 * 7);
                echo "SUCCESS";
            }
            else
                echo "FAILED";
        }
    }

    public function actionForgot() {
        if ($_POST && isset($_POST['forgot'])) {
            $username = $_POST['forgot'];
            $user = User::findbyUsernameEmail($username);
            if ($user != null) {
                $user->generateActivationCode();
                //echo Yii::app()->createAbsoluteUrl('guest/changepassword', array('user' => $user->username, 'key' => $user->activation_code));
                $this->sendForgotMail($user);
                Yii::app()->user->setFlash('forgot', 'success');
            } else {
                Yii::app()->user->setFlash('forgot', 'failed');
            }
        }
        $this->render('forgot');
    }

    public function actionChangePassword() {
        if (isset($_GET['user']) && isset($_GET['key'])) {
            $user = User::findbyUsernameEmail($_GET['user']);
            if ($user == null || $user->activation_code != $_GET['key']) {
                $this->render('changepassword1', array('error' => true));
            } else {
                if (isset($_POST['User'])) {
                    $user->setScenario('forgotPassword');
                    $user->attributes = $_POST['User'];
                    if ($user->validate()) {
                        $realpassword = $user->password;
                        //$user->password = sha1($user->password);
                        $user->activation_code = null;
                        if ($user->save(false)) {
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

    private function sendRegisterMail($model) {
        $subject = 'Pendaftaran di TOKI Learning Center';
        $content = $this->renderPartial('mail/register', array('model' => $model), true);
        $message = new Message;
        $message->setBody($content, 'text/plain');
        $message->subject = $subject;
        //$message->addTo('Petra Novandi <petra.barus@gmail.com>')
        $message->setTo(array($model->email => $model->full_name));
        //$message->from = 'ITB Programming Contest <itbpc@if.itb.ac.id>';
        $message->setFrom(array('toki.learning@gmail.com' => 'TOKI Learning Center'));
        $message->setCc(array('petra.barus@gmail.com' => 'Petra Barus'));
        //$message->setBcc(array('itbpc-committee@googlegroups.com' => 'ITBPC Comittee'));
        $message->setReplyTo(array('toki.learning@gmail.com' => 'TOKI Learning Center'));
        Yii::app()->mail->send($message);
    }

    private function sendForgotMail($model) {
        $subject = 'Perubahan Sandi';
        $content = $this->renderPartial('mail/forgot', array('model' => $model), true);
        $message = new Message;
        $message->setBody($content, 'text/plain');
        $message->subject = $subject;
        //$message->addTo('Petra Novandi <petra.barus@gmail.com>')
        $message->setTo(array($model->email => $model->full_name));
        //$message->from = 'ITB Programming Contest <itbpc@if.itb.ac.id>';
        $message->setFrom(array('toki.learning@gmail.com' => 'TOKI Learning Center'));
        $message->setCc(array('petra.barus@gmail.com' => 'Petra Barus'));
        //$message->setBcc(array('itbpc-committee@googlegroups.com' => 'ITBPC Comittee'));
        $message->setReplyTo(array('toki.learning@gmail.com' => 'TOKI Learning Center'));
        Yii::app()->mail->send($message);
    }

}
