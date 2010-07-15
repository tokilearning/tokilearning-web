<?php

Yii::import("ext.evaluator.base.StandardProblemViewWidgetBase");

class SimpletextProblemViewWidget extends StandardProblemViewWidgetBase {

    public function run() {
        $assetpath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager()->publish($assetpath, false, -1, true);
        $cs = Yii::app()->getClientScript()->registerScriptFile($assets . '/style.css');
        //
        $submission = $this->loadModel();
        //
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        switch ($action) {
            case 'renderviewfile' :
                $this->renderViewFile();
                break;
            case 'submit';
                $this->submitAnswer();
                break;
            default:
                break;
        }
        $this->render('problemview', array(
            'problem' => $this->problem,
            'assets' => $assets,
            'submission' => $this->submission,
            'action' => $action,
        ));
    }

    private function loadModel() {
        $dbCriteria = new CDbCriteria();
        $dbCriteria->addCondition('problem_id = ' . $this->problem->id);
        $dbCriteria->addCondition('submitter_id = ' . $this->submitter->id);
        if ($this->contest == null) {
            $dbCriteria->addCondition('contest_id is NULL');
        } else {
            $dbCriteria->addCondition('contest_id = ' . $this->contest->id);
        }
        $submission = Submission::model()->find($dbCriteria);
        if ($submission == null) {
            //Initialize first time submission
            $submission = new Submission();
            $submission->submitter_id = $this->submitter->id;
            $submission->problem_id = $this->problem->id;
            $submission->contest_id = ($this->contest == null) ? null : $this->contest->id;
            $submission->grade_status = $this->submitStatus;
            $submission->save();
            $this->submission = $submission;
        } else {
            $this->submission = $submission;
        }
        //generate random sequence
        $this->generateRandomSequence();
        $this->submission->save();
        return $this->submission;
    }

    private function generateRandomSequence() {
        $randomseq = $this->submission->getSubmitContent('random_sequence');
        if (!is_array($randomseq)) {
            $randomseq = array();
        }
        $problems = $this->problem->getConfig('problems');
        if (count($randomseq) != count($problems)) {
            for ($i = 0; $i < count($problems); $i++) {
                $randomseq[$i] = $i;
            }
            //shuffle($randomseq);
        }
        $this->submission->setSubmitContent('random_sequence', $randomseq);
    }

    public function submitAnswer() {
        if (!$this->submitLocked) {
            if (isset($_POST['Submission'])) {
                foreach ($_POST['Submission']['answer'] as $key => $answer) {
                    //echo urldecode($answer) . "<br />";
                    $_POST['Submission']['answer'][$key] = urldecode($answer);
                }
                //echo "<pre>";
                //print_r($_POST);
                //echo "</pre>";
                if (isset($_POST['Submission']['save']) || isset($_POST['Submission']['finish'])) {
                    $answers = $_POST['Submission']['answer'];
                    $endanswers = array();
                    $randomseq = $this->submission->getSubmitContent('random_sequence');
                    foreach ($randomseq as $k => $r) {
                        $endanswers[$r] = $answers[$k];
                    }
                    ksort($endanswers);
                    $this->submission->setSubmitContent('answers', $endanswers);
                    $this->submission->grade_status = Submission::GRADE_STATUS_PENDING;
                    $this->submission->save();
                    if ($this->submission->contest !== null)
                        $this->submission->contest->getContestTypeHandler()->afterSubmit($this->submission->contest, $this->submission);
                }
            }
        }
    }

}