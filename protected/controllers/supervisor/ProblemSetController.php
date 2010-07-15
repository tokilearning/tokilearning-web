<?php

class ProblemSetController extends CSupervisorController {

    private $_model;

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
            'problemsDataProvider' => $problemsDataProvider
        ));
    }

    public function actionDelete() {
        $model = $this->loadModel();
        $model->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionProblemLookup() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])){
            $title = $_GET['q'];
            $limit = min($_GET['limit'], 10);
            $criteria = new CDbCriteria;
            $criteria->condition = "title LIKE :sterm";
            $criteria->params = array(":sterm" => "%$title%");
            $criteria->limit = $limit;
            $problems = Problem::model()->findAll($criteria);
            $retval = '';
            foreach ($problems as $problem) {
                $retval .= $problem->getAttribute('id') . '. ' . $problem->getAttribute('title').'|'
                        . $problem->getAttribute('id') . "\n";
            }
            echo $retval;
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
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q']) && isset($_GET['id'])){
            $name = $_GET['q'];
            $tid = $_GET['id'];
            $limit = min($_GET['limit'], 10);
            $criteria = new CDbCriteria;
            $criteria->condition = "name LIKE :sterm AND id != :tid";
            $criteria->params = array(":sterm" => "%$name%", ":tid" => $tid);
            $criteria->limit = $limit;
            $problemsets = ProblemSet::model()->findAll($criteria);
            $retval = '';
            foreach ($problemsets as $problemset) {
                $retval .= $problemset->getAttribute('id') . '. ' . $problemset->getAttribute('name').'|'
                        . $problemset->getAttribute('id') . "\n";
            }
            echo $retval;
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
