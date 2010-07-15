<?php

class ProblemsetController extends CSupervisorController {

    private $_model;
    public $pageTitle = "Bundel Soal";

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ProblemSet', array(
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
        $model = new ProblemSet('create');
        if (isset($_POST['ProblemSet'])) {
            $model->attributes = $_POST['ProblemSet'];
            if ($model->validate()) {
                $model->save(false);
                $this->redirect(array('update', 'id' => $model->id));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        $model->setScenario('update');
        if (isset($_POST['ProblemSet'])) {
            $model->attributes = $_POST['ProblemSet'];
            if ($model->validate()) {
                $model->save(false);
                $this->redirect(array('index'));
            }
        }
        $subProblemSetDataProvider = new CActiveDataProvider('ProblemSet', array(
                    'pagination' => array(
                        'pageSize' => 10,
                    ),
                    'criteria' => array(
                        'condition' => 'parent_id = ' . $model->id
                    )
                ));
        $problemsDataProvider = new CActiveDataProvider('Problem', array(
                    'pagination' => array(
                        'pageSize' => 10,
                    ),
                    'criteria' => array(
                        'join' => 'JOIN problemsets_problems ON problem_id = id',
                        'condition' => 'problemset_id = ' . $model->id,
                    )
                ));
        $this->render('update', array(
            'model' => $model,
            'subProblemSetDataProvider' => $subProblemSetDataProvider,
            'problemsDataProvider' => $problemsDataProvider,
            'currtab' => $_GET['currtab'],
        ));
    }

    public function actionDelete() {
        $model = $this->loadModel();
        $model->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionProblemLookup() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $title = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->condition = "title LIKE :sterm";
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

    public function actionAddProblem() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['id']) && isset($_GET['problemid'])) {
            $model = $this->loadModel();
            $problem = Problem::model()->findByPk($_GET['problemid']);
            if ($problem != null){
                $model->addProblem($problem);
            }
        }
    }

    public function actionRemoveProblem() {
        if (Yii::app()->request->isPostRequest && isset($_GET['id']) && isset($_GET['problemid'])) {
            $model = $this->loadModel();
            $problem = Problem::model()->findByPk($_GET['problemid']);
            if ($problem != null){
                $model->removeProblem($problem);
                if (!isset($_GET['ajax']))
                        $this->redirect(array('index'));
            }
        }
    }

    public function actionProblemSetLookup() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term']) && isset($_GET['id'])){
            $name = $_GET['term'];
            $tid = $_GET['id'];
            $criteria = new CDbCriteria;
            $criteria->condition = "name LIKE :sterm AND id != :tid";
            $criteria->params = array(":sterm" => "%$name%", ":tid" => $tid);
            $problemsets = ProblemSet::model()->findAll($criteria);
            $retval = array();
            foreach ($problemsets as $problemset) {
                $retval[] = array(
                    'value' => $problemset->getAttribute('id'),
                    'label' => $problemset->getAttribute('id') . '. ' . $problemset->getAttribute('name'),
                );
            }
            echo CJSON::encode($retval);
        }
    }

    public function actionAddProblemSet() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['id']) && isset($_GET['problemsetid'])) {
            $model = $this->loadModel();
            $problemset = ProblemSet::model()->findByPk($_GET['problemsetid']);
            if ($problemset != null){
                $model->addProblemSet($problemset);
            }
        }
    }

    public function actionRemoveProblemSet() {
        if (Yii::app()->request->isPostRequest && isset($_GET['id']) && isset($_GET['problemsetid'])) {
            $model = $this->loadModel();
            $problemset = ProblemSet::model()->findByPk($_GET['problemsetid']);
            if ($problemset != null){
                $model->removeProblemSet($problemset);
                if (!isset($_GET['ajax']))
                        $this->redirect(array('index'));
            }
        }
    }

    public function actionPublish(){
        $model = $this->loadModel();
        $model->status = ProblemSet::PROBLEM_SET_STATUS_PUBLISHED;
        $model->save();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionUnpublish(){
        $model = $this->loadModel();
        $model->status = ProblemSet::PROBLEM_SET_STATUS_UNPUBLISHED;
        $model->save();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionIncreaserank(){
        $model = $this->loadModel();
        if (isset($_GET['pid'])){
            $problem = Problem::model()->findbyPk($_GET['pid']);
            if ($problem !== NULL && $model->hasProblem($problem)){
                $model->increaseProblemRank($problem);
                if (!isset($_GET['ajax']))
                        $this->redirect(array('update', 'id' => $model->id, 'currtab' => 'problems'));
            } else {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionDecreaserank(){
        $model = $this->loadModel();
        if (isset($_GET['pid'])){
            $problem = Problem::model()->findbyPk($_GET['pid']);
            if ($problem !== NULL && $model->hasProblem($problem)){
                $model->decreaseProblemRank($problem);
                if (!isset($_GET['ajax']))
                        $this->redirect(array('update', 'id' => $model->id, 'currtab' => 'problems'));
            } else {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = ProblemSet::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}
