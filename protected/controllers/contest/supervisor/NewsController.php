<?php

class NewsController extends CContestController {

    public $layout = 'application.views.layouts.contestsupervisor';
    private $_model;

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'expression' => 'Yii::app()->controller->isSupervisor()'
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ContestNews', array(
                    'criteria' => array(
                        'condition' => 'contest_id = :contestid',
                        'params' => array(
                            'contestid' => $this->getContest()->id
                        ),
                        'with' => array('author'),
                    ),
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        $this->render('index',
                array(
                    'dataProvider' => $dataProvider
                )
        );
    }

    public function actionCreate(){
        $model = new ContestNews('create');
        if (isset($_POST['ContestNews'])){
            $model->attributes = $_POST['ContestNews'];
            if ($model->validate()){
                $model->contest_id = $this->getContest()->id;
                $model->author_id = Yii::app()->user->getId();
                if ($model->save(false)){
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionView() {
        $model = $this->loadModel();
        $this->render('view', array('model' => $model));
    }
    
    public function actionDelete() {
        // we only allow deletion via POST request
        $this->loadModel()->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        if (isset($_POST['ContestNews'])){
            $model->attributes = $_POST['ContestNews'];
            if ($model->validate()){
                if ($model->save(false)){
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('update', array('model' => $model));
    }

    public function actionPublish(){
        $model = $this->loadModel();
        $model->publish()->save();
        $this->redirect(array('index'));
    }

    public function actionUnpublish(){
        $model = $this->loadModel();
        $model->unpublish()->save();
        $this->redirect(array('index'));
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = ContestNews::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}
