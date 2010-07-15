<?php

class ProblemController extends CContestController {

    public function actionIndex() {
         $dataProvider = new CActiveDataProvider('Problem', array(
            'pagination' => array(
                'pageSize' => 10,
            ),
            'criteria' => array(
                'join' => 'JOIN contests_problems ON problem_id = id',
                'condition' => 'contest_id = '.$this->getContest()->id.' AND contests_problems.status != '.Contest::CONTEST_VISIBILITY_HIDDEN,
            )
        ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionView() {
        if (isset($_GET['alias'])){
            $problem = $this->getContest()->getProblemByAlias($_GET['alias']);
        }
        if($problem == null){
            throw new CHttpException(404, 'The requested page does not exist.');
        } else {
            if (isset($_GET['view']) && $_GET['view'] == 'full'){
                $this->layout = 'application.views.layouts.column1';
                $this->render('_problemview2', array('problem' =>  $problem));
            } else {
                if ($this->getContest()->getProblemStatus($problem) == Contest::CONTEST_PROBLEM_HIDDEN){
                    throw new CHttpException(400, 'Requested page not found');
                } else {
                    $submissionDataProvider = new CActiveDataProvider('Submission', array(
                        'pagination' => array(
                            'pageSize' => 20,
                        ),
                        'criteria' => array(
                            'select' => array('id', 'submitted_time', 'grade_status'),
                            'condition' => 'contest_id = :contest_id AND problem_id = :problem_id AND submitter_id = :submitter_id',
                            'params' => array(
                                'problem_id' => $problem->id,
                                'submitter_id' => Yii::app()->user->getId(),
                                'contest_id' => $this->getContest()->id
                            ),
                        )
                    ));

                    $activeTab = $_GET['return'];
                    $this->render('view', array(
                            'problem' => $problem,
                            'activeTab' => $activeTab,
                            'submissionDataProvider' => $submissionDataProvider
                        ));
                }
            }
        }
    }

    public function actionSubmitAnswer(){
        if (Yii::app()->request->isPostRequest){
            if (isset($_GET['alias'])){
                $problem = $this->getContest()->getProblemByAlias($_GET['alias']);
            }
            if($problem == null){
                throw new CHttpException(404, 'The requested page does not exist.');
            } else {
                if ($this->getContest()->getProblemStatus($problem) == Contest::CONTEST_PROBLEM_OPEN &&
                        !$this->getContest()->isExpired()){
                    if (!isset($_POST['Submission']['id'])){
                        $submission = new Submission();
                        $submission->submitter_id = Yii::app()->user->getId();
                        $submission->problem_id = $problem->id;
                        $submission->contest_id = $this->getContest()->id;
                        $submission->grade_status = Submission::GRADE_STATUS_PENDING;
                        try {
                            ProblemHelper::submitAnswer($submission);
                            $submission->save();
                            $this->redirect(array('view', 'alias' => $_GET['alias'], 'return' => 'submission'));
                        } catch (Exception $ex) {
                            $submission->addError('answer', $ex->getMessage());
                            $this->render('view',
                                    array(
                                        'problem' =>  $problem,
                                        'activeTab' => 'submit',
                                        'submission' => $submission
                                        )
                            );
                        }
                    } else {
                        //TODO
                    }
                } else {
                    throw new CHttpException(404, "Page not found");
                }
            }
        } else {
            throw new CHttpException(400, "Bad request");
        }
    }

}
