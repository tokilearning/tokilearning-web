<?php

/**
 *
 */
class SubmissionController extends CMemberController {

    public function actionIndex() {
        $submissionDataProvider = new CActiveDataProvider('Submission', array(
                    'pagination' => array(
                        'pageSize' => 30,
                    ),
                    'criteria' => array(
                        'select' => array('id', 'submitted_time', 'problem_id', 'grade_status', 'grade_content', 'score', 'verdict'),
                        'condition' => 'contest_id IS NULL AND submitter_id = :submitter_id',
                        'params' => array(
                            'submitter_id' => Yii::app()->user->getId()
                        ),
                        'with' => array(
                            'problem' => array('select' => array('id', 'title')),
                            'problem.problemtype' => array('select' => array('id', 'name')),
                        )
                    )
                ));
        $this->render('index', array('submissionDataProvider' => $submissionDataProvider));
    }

    public function actionView() {
        if (isset($_GET['id']))
            $model = Submission::model()->with(array(
                        'problem' => array('select' => array('id', 'title', 'token')),
                        'problem.problemtype' => array('select' => array('name'))
                    ))->findbyPk($_GET['id']);
        if ($model !== null) {
            if ($model->submitter_id == Yii::app()->user->getId() &&
                    $model->contest_id == NULL) {
                $this->render('view', array('model' => $model));
            } else {
                throw new CHttpException(403, 'Unauthorized access');
            }
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

}
