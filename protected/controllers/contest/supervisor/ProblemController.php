<?php

class ProblemController extends CContestController {

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
        $dataProvider = new CActiveDataProvider('Problem', array(
            'pagination' => array(
                'pageSize' => 10,
            ),
            'criteria' => array(
                'join' => 'JOIN contests_problems ON problem_id = id',
                'condition' => 'contest_id = '.$this->getContest()->id,
            )
        ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionProblemLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $title = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->join = "LEFT JOIN problem_privileges ON problem_id = id";
            $criteria->condition = "title LIKE :sterm AND (user_id = " . Yii::app()->user->id . " OR author_id = " . Yii::app()->user->id . ")";
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

    public function actionAddProblem(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['problemid'])) {
            $model = $this->loadModel();
            $this->getContest()->addProblem($model);
        }
    }

    public function actionRemoveProblem(){
        if (Yii::app()->request->isPostRequest && isset($_GET['problemid'])) {
            $model = $this->loadModel();
            $this->getContest()->removeProblem($model);
        }
    }

    public function actionOpenProblem(){
        $model = $this->loadModel();
        $this->getContest()->setProblemStatus($model, Contest::CONTEST_PROBLEM_OPEN);
        $this->redirect(array('index'));
    }

    public function actionCloseProblem(){
        $model = $this->loadModel();
        $this->getContest()->setProblemStatus($model, Contest::CONTEST_PROBLEM_CLOSED);
        $this->redirect(array('index'));
    }

    public function actionHideProblem(){
        $model = $this->loadModel();
        $this->getContest()->setProblemStatus($model, Contest::CONTEST_PROBLEM_HIDDEN);
        $this->redirect(array('index'));
    }

    public function actionView() {
        $this->render('view');
    }

    public function actionSubmit() {
        $this->render('view');
    }

    public function actionSubmissions() {
        $this->render('view');
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['problemid']))
                $this->_model = Problem::model()->findbyPk($_GET['problemid']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}
