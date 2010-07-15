<?php

/**
 *
 */
class PastebinController extends CMemberController {

    public $pageTitle = "Pastebin";
    private $_model;
    
    public function actionIndex(){
        $dataProvider = new CActiveDataProvider('PasteBin', array(
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionCreate(){
        $model = new PasteBin();
        if (isset($_POST['PasteBin'])){
            $model->attributes = $_POST['PasteBin'];
            $model->owner_id = Yii::app()->user->getId();
            if ($model->save()){
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionView(){
        $model = $this->loadModel();
        $this->render('view', array('model' => $model));
    }

    public function actionDelete(){
        // we only allow deletion via POST request
        $this->loadModel()->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = PasteBin::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }
}
