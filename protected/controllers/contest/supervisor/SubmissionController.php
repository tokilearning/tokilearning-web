<?php

class SubmissionController extends CContestController {

    public $layout = 'application.views.layouts.contestsupervisor';

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
        $criteria->select = array('id', 'submitted_time', 'problem_id', 'grade_status');
        $criteria->with = array(
                            'problem' => array('select' => array('id', 'title')),
                            'submitter' => array('select' => array('id', 'full_name'))
                        );
        if (isset($_GET['filtercontestant'])){
            if (($uid = $_GET['filtercontestant']) != 'all'){
                $criteria->addCondition('submitter_id = '.$uid);
            }
        }
        if (isset($_GET['filterproblem'])){
            if (($pid = $_GET['filterproblem']) != 'all'){
                $p = $this->getContest()->getProblemByAlias($pid);
                $criteria->addCondition('problem_id = '.$p->id);
            }
        }
        $dataProvider = new CActiveDataProvider('Submission', array(
            'pagination' => array(
                        'pageSize' => 20,
                    ),
            'criteria' => $criteria
        ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionView(){
        if (isset($_GET['id']))
            $model = Submission::model()->with(array(
                    'problem' => array('select' => array('id', 'title')),
                    'problem.problemtype' => array('select' => array('name')),
                    'submitter' => array('select' => array('id', 'full_name'))
                ))->findbyPk($_GET['id']);
        if ($model !== null){
            $this->render('view', array('model' => $model));
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionRegrade(){
        if (isset($_GET['id']))
            $model = Submission::model()->findbyPk($_GET['id']);
        if ($model !== null){
            $model->setGradeStatus(Submission::GRADE_STATUS_PENDING);
            $model->save(false);
            $this->redirect(array('index'));
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionAJAXRegrade(){
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest){
            if (isset($_POST['mark'])){
                foreach($_POST['mark'] as $regradeid){
                    $model = Submission::model()->findbyPk($regradeid);
                    if ($model !== null){
                        $model->setGradeStatus(Submission::GRADE_STATUS_PENDING);
                        $model->save(false);
                    }
                }
            }
        }
    }

}
