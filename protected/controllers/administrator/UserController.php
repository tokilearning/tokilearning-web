<?php

class UserController extends CAdminController {

    public $layout = 'application.views.layouts.column2';
    private $_model;

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('User', array(
                    'pagination' => array(
                        'pageSize' => 10,
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
        if (isset($_POST['User'])){
            $model->attributes = $_POST['User'];
            if ($model->validate()){
                $model->password = sha1($model->password);
                $model->save(false);
                $this->redirect(array('index'));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        if (isset($_POST['User'])){
            $model->attributes = $_POST['User'];
            if ($model->validate()){
                $model->password = sha1($model->password);
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
