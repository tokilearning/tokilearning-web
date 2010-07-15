<?php

class UserController extends CAdminController {

    public $layout = 'application.views.layouts.column2';
    private $_model;

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => array(
                        'select' => array(
                            'id', 'username', 'full_name', 'last_login', 'last_activity'
                        )
                    ),
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionView() {
        $model = $this->loadModel();
        $this->render('view', array('model' => $model));
    }

    public function actionCreate() {
        $model = new User('create');
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->validate()) {
                $model->save(false);
                $group = Group::model()->findbyAttributes(array('name' => 'learner'));
                if ($group != null) {
                    Yii::app()->authManager->assign($group->name, $model->id);
                    $group->addMember($model);
                }
                $this->redirect(array('index'));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        $model->setScenario('adminUpdate');
        if (isset($_POST['User'])) {
			$originalpassword = $model->password;
            $model->setAttributes($_POST['User'], false);
			if (strlen($model->password) == 0) {
                $model->password = $originalpassword;
            }
            if ($model->validate()) {
                $model->save(false);
                $this->redirect(array('index'));
            }
        }
        $this->render('update', array('model' => $model));
    }

    public function actionDelete() {
        $model = $this->loadModel();
        if (!in_array($model->id, array(0, 1, 2))) {
            $model->delete();
            if (!isset($_GET['ajax']))
                $this->redirect(array('index'));
        } else {
            $this->redirect(array('index'));
        }
    }

    public function actionBatchCreate() {
        $form = new BatchUserCreateForm('create');
        if (isset($_POST['BatchUserCreateForm'])) {
            $form->setAttributes($_POST['BatchUserCreateForm']);
            if ($form->validate()) {
                $this->layout = 'application.views.layouts.column1';
                $generatedUsers = $form->generateUsers();
                $group = Group::model()->findbyAttributes(array('name' => 'learner'));

                foreach ($generatedUsers as $guser) {
                    $user = new User();
                    $user->full_name = $guser['full_name'];
                    $user->username = $guser['username'];
                    $user->email = $guser['email'];
                    $user->password = $guser['password'];

                    $user->save(false);
                    if ($group != null) {
                        Yii::app()->authManager->assign($group->name, $user->id);
                        $group->addMember($user);
                    }
                }
                $this->render('batchcreate_result', array('generatedUsers' => $generatedUsers));
                return;
            }
        }
        $this->render('batchcreate', array('form' => $form));
    }

    public function actionBatchUpload() {
        $this->render('batchupload');
    }

    public function actionSearch() {
        if (isset($_POST)) {
            if (isset($_POST['delete']) && isset($_POST['mark']) && is_array($_POST['mark'])) {
                //
                $this->batchDelete($_POST['mark']);
            } else if (isset($_POST['password']) && isset($_POST['mark']) && is_array($_POST['mark'])) {
                //
                $users = $this->generatePasswords($_POST['mark']);
                $this->layout = 'application.views.layouts.column1';
                $this->render('password', array('users' => $users));
                return;
            }
        }
        if (isset($_GET['term'])) {
            $term = trim($_GET['term']);
            $criteria = new CDbCriteria;
            $criteria->condition = "id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm";
            $criteria->params = array(":sterm" => "%$term%");
            $criteria->limit = -1;
            $count = User::model()->count($criteria);
            $dataProvider = new CActiveDataProvider('User', array(
                        'criteria' => $criteria,
                        'pagination' => array(
                            'pageSize' => $count
                        ),
                    ));
        }
        $this->render('search', array(
            'dataProvider' => $dataProvider
        ));
    }

    //
    private function batchDelete($mark) {
        foreach ($mark as $id) {
            $user = User::model()->findByPk($id);
            if ($user != null) {
                $user->delete();
            }
        }
    }

    private function generatePasswords($mark) {
        $users = array();
        foreach ($mark as $id) {
            $user = User::model()->findByPk($id);
            if ($user != null) {
                $newpassword = CTextHelper::random('distinct');
                $user->password = $newpassword;
                $user->save(false);
                $users[] = array(
                    'username' => $user->username,
                    'full_name' => $user->full_name,
                    'password' => $newpassword,
                    'email' => $user->email,
                );
            }
        }
        return $users;
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = User::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}
