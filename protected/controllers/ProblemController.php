<?php

/**
 *
 */
class ProblemController extends CMemberController {

    private $_model;

    public function accessRules() {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('view'),
                'users' => array('*'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->redirect(array('/problemset'));
    }

    public function actionAll() {
        $problemsetid = 1;
        $dataProvider = new CActiveDataProvider('Problem', array(
                    'criteria' => array(
                        'select' => array('id', 'title', 'description'),
                        'join' => 'LEFT JOIN problemsets_problems ON problemsets_problems.problem_id=id',
                        'condition' => "problemsets_problems.problemset_id=$problemsetid AND visibility = ".Problem::VISIBILITY_PUBLIC,
                    ),
                    'pagination' => array(
                        'pageSize' => 25
                    )
                ));
        $this->render('all', array('dataProvider' => $dataProvider));
    }

    public function actionView() {
        $model = $this->loadModel();
        $submissionDataProvider = new CActiveDataProvider('Submission', array(
            'pagination' => array(
                'pageSize' => 20,
            ),
            'criteria' => array(
                'select' => array('id', 'submitted_time', 'grade_status', 'grade_content', 'verdict', 'score'),
                'condition' => 'contest_id IS NULL AND problem_id = :problem_id AND submitter_id = :submitter_id',
                'params' => array(
                    'problem_id' => $model->id,
                    'submitter_id' => Yii::app()->user->getId()
                ),
            )
        ));
        if (Yii::app()->user->isGuest) {
            $this->layout = 'application.views.layouts.static';
            $this->render('guestview', array('model' => $model,));
        } else {
            $this->render('view', array('model' => $model,'submissionDataProvider' => $submissionDataProvider));
        }
    }

    public function actionSubmissions() {
        $model = $this->loadModel();
        $submissionDataProvider = new CActiveDataProvider('Submission', array(
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                    'criteria' => array(
                        'select' => array('id', 'submitted_time', 'grade_status', 'grade_content', 'verdict', 'score'),
                        'condition' => 'contest_id IS NULL AND problem_id = :problem_id AND submitter_id = :submitter_id',
                        'params' => array(
                            'problem_id' => $model->id,
                            'submitter_id' => Yii::app()->user->getId()
                        ),
                    )
                ));
        $this->render('submissions', array('model' => $model, 'submissionDataProvider' => $submissionDataProvider));
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Problem::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            if ($this->_model->visibility != Problem::VISIBILITY_PUBLIC)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}
