<?php

Yii::import("ext.evaluator.types.multiplesource.model.MultiplesourceArchive");
class MultiplesourceSubmissionViewWidget extends CWidget {

    public $submission;
    public $viewLevel = 0; //0, 1, 2

    public function run(){
        if (isset($_GET['downloadsource']))
            $this->downloadSource();

        $ar = MultiplesourceArchive::model()->find(array('condition' => 'submission_id=' . $this->submission->id));

        $dir = $ar->extract();
        $files = MultiplesourceArchive::listFiles($dir);
        
        $this->render('submissionview', array(
            'submission' => $this->submission,
            'viewLevel' => $this->viewLevel,
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