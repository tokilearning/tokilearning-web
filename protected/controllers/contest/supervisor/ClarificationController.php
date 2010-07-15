<?php

class ClarificationController extends CContestController {

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
        $criteria = new CDbCriteria;
        $criteria->condition = 'contest_id = '.$this->getContest()->id;
        if (isset($_GET['filterbyproblem'])){
            switch ($_GET['filterbyproblem']){
                case 'all':
                    break;
                case 'others' :
                    $criteria->addCondition('problem_id IS NULL');
                    break;
                default:
                    $pid = $_GET['filterbyproblem'];
                    $problem = $this->getContest()->getProblemByAlias($pid);
                    if ($problem != null){
                        $criteria->addCondition('problem_id = '.$problem->id);
                    }
                    break;
            }
        }
        $dataProvider = new CActiveDataProvider('Clarification', array(
            'pagination' => array(
                'pageSize' => 10,
            ),
            'criteria' => $criteria,
        ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionView(){
        $model = $this->loadModel();
        $this->render('view', array('model' => $model));
    }

    public function actionAnswer(){
        $model = $this->loadModel();
        $model->setScenario('answer');
        if (isset($_POST['Clarification'])){
            $model->attributes = $_POST['Clarification'];
            if ($model->validate()){
                $model->answered_time = new CDbExpression('NOW()');
                $model->status = Clarification::STATUS_ANSWERED;
                $model->answerer_id = Yii::app()->user->getId();
                $model->save(false);
                $this->redirect(array('index'));
            }
        }
        $this->render('view', array('model' => $model));
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Clarification::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            if ($this->_model->contest_id != $this->getContest()->id)
                throw new CHttpException(403, 'Unauthorized access.');
        }
        return $this->_model;
    }
}
