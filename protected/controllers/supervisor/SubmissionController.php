<?php

class SubmissionController extends CSupervisorController {

    public function actionIndex(){
        $dataProvider = new CActiveDataProvider('Submission', array(
                    'pagination' => array(
                        'pageSize' => 30,
                    ),
                    'criteria' => array(
                        'select' => array('id', 'submitted_time', 'problem_id', 'grade_status', 'grade_time'),
                        'condition' => 'contest_id IS NULL',
                        'params' => array(
                            'submitter_id' => Yii::app()->user->getId()
                        ),
                        'with' => array(
                            'problem' => array('select' => array('title')),
                            'problem.problemtype' => array('select' => array('name')),
                            'submitter' => array('select' => array('full_name'))
                        )
                    )
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

    public function actionMemberLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])){
            $name = $_GET['q'];
            $limit = min($_GET['limit'], 10);
            $criteria = new CDbCriteria;
            $criteria->condition = "id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm";
            $criteria->params = array(":sterm" => "%$name%");
            $criteria->limit = $limit;
            $users = User::model()->findAll($criteria);
            $retval = '';
            foreach($users as $user)
            {
                $retval .= $user->getAttribute('id'). '. '
                        .$user->getAttribute('full_name').' ('
                        .$user->getAttribute('username').' / '
                        .$user->getAttribute('email')
                        . ')'.'|'.$user->getAttribute('id')."\n";
            }
            echo $retval;
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