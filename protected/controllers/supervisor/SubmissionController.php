<?php

class SubmissionController extends CSupervisorController {

    public function actionIndex(){
	$criteria = new CDbCriteria();
	$criteria->select = array('id', 'submitted_time', 'problem_id', 'grade_status', 'grade_time', 'grade_content', 'verdict', 'score');
	$criteria->condition = "contest_id IS NULL";
	$criteria->with = array(
		'problem' => array('select' => array('title')),
                'problem.problemtype' => array('select' => array('name')),
                'submitter' => array('select' => array('full_name'))
	);
	if (isset($_GET['filterproblem']) && ($_GET['filterproblem'] != 'all') && is_numeric($_GET['filterproblem'])){
            $criteria->addCondition("problem_id = ".$_GET['filterproblem']);
	}
	if (isset($_GET['filtermember']) && ($_GET['filtermember'] != 'all') && is_numeric($_GET['filtermember'])){
            $criteria->addCondition("submitter_id = ".$_GET['filtermember']);
        }

        $dataProvider = new CActiveDataProvider('Submission', array(
                    'pagination' => array(
                        'pageSize' => 30,
                    ),
                    'criteria' => $criteria,
                
                ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionView(){
        if (isset($_GET['id']))
            $model = Submission::model()->with(array(
                    'problem' => array('select' => array('id', 'title', 'token')),
                    'problem.problemtype' => array('select' => array('name')),
                    'submitter' => array('select' => array('id', 'full_name'))
                ))->findbyPk($_GET['id']);
        if ($model !== null){
            $this->render('view', array('model' => $model));
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionUpdate(){
        if (isset($_GET['id']))
            $model = Submission::model()->with(array(
                    'problem' => array('select' => array('id', 'title', 'token')),
                    'problem.problemtype' => array('select' => array('name')),
                    'submitter' => array('select' => array('id', 'full_name'))
                ))->findbyPk($_GET['id']);
        if ($model !== null){
            $this->render('update', array('model' => $model));
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionRegrade(){
        if (isset($_GET['id']))
            //TODO select id and grade_status only
            $model = Submission::model()->findbyPk($_GET['id']);
        if ($model !== null){
            $model->setGradeStatus(Submission::GRADE_STATUS_PENDING);
            $model->save(false);
            $this->redirect(array('index'));
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionProblemLookup(){
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
                    'label' => $problem->getAttribute('id') . '. ' . $problem->getAttribute('title'),
                );
            }
            echo CJSON::encode($retval);
        }
    }

    public function actionMemberLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $name = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->condition = "id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm";
            $criteria->params = array(":sterm" => "%$name%");
            $users = User::model()->findAll($criteria);
            $retval = array();
            foreach($users as $user)
            {
                $retval[] = array(
                    'value' => $user->getAttribute('id'),
                    'label' => $user->getAttribute('id').'. '.
                        $user->getAttribute('full_name').' ('.
                        $user->getAttribute('username').'/'.
                        $user->getAttribute('email').')',
                );
            }
            echo CJSON::encode($retval);
        }
    }

    public function actionBatchRegrade(){
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

    public function actionBatchSkip(){
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest){
            if (isset($_POST['mark'])){
                foreach($_POST['mark'] as $regradeid){
                    $model = Submission::model()->findbyPk($regradeid);
                    if ($model !== null){
                        $model->setGradeStatus(Submission::GRADE_STATUS_NOGRADE);
                        $model->save(false);
                    }
                }
            }
        }
    }
}
