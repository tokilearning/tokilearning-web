<?php

class AnnouncementController extends CAdminController {

    public $layout = 'application.views.layouts.column2';
    private $_model;

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Announcement', array(
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionView() {
        $this->render('view', array(
            'model' => $this->loadModel(),
        ));
    }

    public function actionCreate() {
        $model = new Announcement('create');

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);

        if (isset($_POST['Announcement'])) {
            $model->attributes = $_POST['Announcement'];
            $model->created_date = new CDbExpression('NOW()');
            $model->author_id = Yii::app()->user->getId();
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        $model->setScenario('update');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Announcement'])) {

            $model->attributes = $_POST['Announcement'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete() {
        // we only allow deletion via POST request
        $this->loadModel()->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionPublish() {
        $model = $this->loadModel();
        $model->publish()->save();
        $this->redirect(array('index'));
    }

    public function actionUnpublish() {
        $model = $this->loadModel();
        $model->unpublish()->save();
        $this->redirect(array('index'));
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Announcement::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}
