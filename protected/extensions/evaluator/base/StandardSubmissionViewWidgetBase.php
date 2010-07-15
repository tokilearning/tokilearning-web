<?php

Yii::import("ext.evaluator.base.ParameterizedWidget");

abstract class StandardSubmissionViewWidgetBase extends ParameterizedWidget {

    public $submission;
    public $viewLevel = 0; //0, 1, 2

    public function run() {
        parent::run();
        
        $this->render('submissionview', array(
            'submission' => $this->submission,
            'viewLevel' => $this->viewLevel,
        ));
    }
    
    protected function processAction() {
        if ($_GET['action'] == 'download') {
            $this->downloadSource();
        }
    }

    private function downloadSource() {
        ob_clean();

        $contest = Contest::model()->findByPk($this->submission->contest_id);
        $submitter = User::model()->findByPk($this->submission->submitter_id);

        header('Content-type: text/plain');
        header('Content-Disposition: attachment; filename="submission-' . $contest->name . '-' . $submitter->username . '-' . $this->submission->id . '.' . $this->submission->getSubmitContent('source_lang') . '"');
        echo $this->submission->getSubmitContent('source_content');
        exit;
    }

}

?>
