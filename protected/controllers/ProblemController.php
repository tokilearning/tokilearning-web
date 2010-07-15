<?php

/**
 *
 */
class ProblemController extends CMemberController {
    private $_model;

    public function actionIndex(){
        $this->redirect(array('/problemset'));
    }
    
    public function actionView(){
        $model = $this->loadModel();
        if ($model->visibility == Problem::VISIBILITY_PUBLIC){
            if (isset($_GET['view']) && $_GET['view'] == 'full'){
                $this->layout = 'application.views.layouts.column1';
                $this->render('_problem2', array('model' =>  $model));
            } else {
                $submissionDataProvider = new CActiveDataProvider('Submission', array(
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                    'criteria' => array(
                        'select' => array('id', 'submitted_time', 'grade_status'),
                        'condition' => 'contest_id IS NULL AND problem_id = :problem_id AND submitter_id = :submitter_id',
                        'params' => array(
                            'problem_id' => $model->id,
                            'submitter_id' => Yii::app()->user->getId()
                        ),
                    )
                ));
                
                $activeTab = $_GET['return'];
                $this->render('view', array(
                        'model' =>  $model,
                        'activeTab' => $activeTab,
                        'submissionDataProvider' => $submissionDataProvider
                    ));
            }
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionSubmitAnswer(){
        $model = $this->loadModel();
        if ($model->visibility == Problem::VISIBILITY_PUBLIC){
            if (Yii::app()->request->isPostRequest){
                if (!isset($_POST['Submission']['id'])){
                    $submission = new Submission();
                    $submission->submitter_id = Yii::app()->user->getId();
                    $submission->problem_id = $model->id;
                    $submission->contest_id = NULL;
                    $submission->grade_status = Submission::GRADE_STATUS_PENDING;
                    try {
                        ProblemHelper::submitAnswer($submission);
                        $submission->save();
                        $this->redirect(array('view', 'id' => $model->id, 'return' => 'submission'));
                    } catch (Exception $ex) {
                        $submission->addError('answer', $ex->getMessage());
                        $this->render('view',
                                array(
                                    'model' =>  $model,
                                    'activeTab' => 'submit',
                                    'submission' => $submission
                                    )
                        );
                    }
                } else {
                    //TODO
                }
            } else {
                throw new CHttpException(400, "Bad request");
            }
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }
    
    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Problem::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }
    
}