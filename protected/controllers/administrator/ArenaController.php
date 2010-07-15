<?php

class ArenaController extends CAdminController {

    public $layout = 'application.views.layouts.column2';
    private $_model;

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Arena', array(
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionCreate() {
        $model = new Arena('create');

        if (isset($_POST['Arena'])) {
            $model->attributes = $_POST['Arena'];
            $model->creator_id = Yii::app()->user->id;

            if ($model->validate()) {
                $model->save(false);
                $this->redirect($this->createUrl('index'));
            }
        }

        $this->render('create' , array('model' => $model));
    }

    public function actionUpdate() {
        $model = $this->loadModel();

        if (isset($_POST['Arena'])) {
            $model->attributes = $_POST['Arena'];
            if ($model->validate()) {
                $model->save(false);
            }
        }

        $memberDataProvider=new CActiveDataProvider('User', array(
            'criteria'=>array(
                    'join' => 'JOIN arenas_users ON user_id = id',
                    'condition' => 'arena_id = '.$model->id,
                ),
            'pagination'=>array(
                'pageSize' => 20,
                ),
            )
        );

        $problemsDataProvider = new CActiveDataProvider('Problem' , array(
            'criteria' => array(
                'join' => 'JOIN arenas_problems ON problem_id = id',
                'condition' => 'arena_id = ' . $model->id
            ),
            'pagination' => array(
                'pageSize' => 20
            )
        ));

        $this->render('update' , array('model' => $model , 'memberDataProvider' => $memberDataProvider , 'problemsDataProvider' => $problemsDataProvider));
    }

    public function actionProblemLookup() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $title = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->condition = "title LIKE :sterm OR comment LIKE :sterm OR description LIKE :sterm";
            $criteria->params = array(":sterm" => "%$title%");
            $problems = Problem::model()->findAll($criteria);
            $retval = array();
            foreach ($problems as $problem) {
                $retval[] = array(
                    'value' => $problem->getAttribute('id'),
                    'label' => $problem->getAttribute('id') . '. ' . $problem->getAttribute('title')
                );
            }
            echo CJSON::encode($retval);
        }
    }

    public function actionAddMember(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
            $model = $this->loadModel();
            if (isset($_GET['memberid'])){
                //TODO:
                $user = User::model()->findByPk($_GET['memberid']);
                if ($user != null){
                    $model->addMember($user);
                }
            }
        }
    }

    public function actionRemoveMember(){
        if (Yii::app()->request->isPostRequest && isset($_GET['id']) && isset($_GET['memberid'])) {
            $model = $this->loadModel();
            //TODO:
            $user = User::model()->findByPk($_GET['memberid']);
            if ($user != null){
                $model->removeMember($user);
                if (!isset($_GET['ajax']))
                    $this->redirect(array('index'));
            }
        }
    }

    public function actionAddProblem() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['id']) && isset($_GET['problemid'])) {
            $model = $this->loadModel();
            $problem = Problem::model()->findByPK($_GET['problemid']);
            if ($problem !== NULL) {
                $problem->addArena($model);
            }
        }
    }

    public function actionRemoveProblem(){
        if (Yii::app()->request->isPostRequest && isset($_GET['id']) && isset($_GET['problemid'])) {
            $model = $this->loadModel();
            $problem = Problem::model()->findByPK($_GET['problemid']);
            if ($problem !== NULL) {
                $problem->removeArena($model);
            }
        }
    }

    public function actionDelete() {
        $model = $this->loadModel();

        $model->delete();
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Arena::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }
}
