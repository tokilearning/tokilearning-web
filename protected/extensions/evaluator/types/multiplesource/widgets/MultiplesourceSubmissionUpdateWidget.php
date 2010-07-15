<?php

Yii::import("ext.evaluator.types.multiplesource.model.MultiplesourceArchive");
class MultiplesourceSubmissionUpdateWidget extends CWidget {

    public $submission;

    public function run(){
        if (isset($_GET['downloadsource']))
            $this->downloadSource();

        if (isset($_POST['Submission'])){
            $this->submission->setScenario('update');
            $this->submission->setAttributes($_POST['Submission']);
            $this->submission->save();
        }

        $ar = MultiplesourceArchive::model()->find(array('condition' => 'submission_id=' . $this->submission->id));

        $dir = $ar->extract();
        $files = MultiplesourceArchive::listFiles($dir);

        $this->render('submissionupdate', array(
            'submission' => $this->submission,
            'files' => $files
        ));

        exec("rm -rf " . $dir);
    }

    private function downloadSource() {
        ob_clean();

        $submitter = User::model()->findByPk($this->submission->submitter_id);
        $ar = MultiplesourceArchive::model()->find(array('condition' => 'submission_id = ' . $this->submission->id));

        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="submission-'.$submitter->username.'-'.$this->submission->id.'.'.$this->submission->getSubmitContent('source_lang').'"');
        echo $ar->file;
        exit;
    }
}