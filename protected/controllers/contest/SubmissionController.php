<?php

class SubmissionController extends CContestController {

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Submission', array(
            'criteria'=>array(
                'condition' => 'submitter_id = :submitter_id AND contest_id = :contest_id',
                'params' => array(
                        'submitter_id' => Yii::app()->user->getId(),
                        'contest_id' => $this->getContest()->id
                    ),
            ),
            'pagination'=>array(
                'pageSize'=>20,
            ),
        ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionView() {
        if (isset($_GET['id']))
            $model = Submission::model()->with(array(
                    'problem' => array('select' => array('id', 'title', 'token')),
                    'problem.problemtype' => array('select' => array('name'))
                ))->findbyPk($_GET['id']);
        if ($model !== null){
            if ($model->submitter_id == Yii::app()->user->getId() &&
                $model->contest_id == $this->getContest()->id){
                $this->render('view', array('model' => $model));
            } else {
                throw new CHttpException(403, 'Unauthorized access');
            }
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }
    
    
}
