<?php


class BatchioiSubmissionUpdateWidget extends CWidget {

    public $submission;

    public function run(){
        if (isset($_POST['Submission'])){
            $this->submission->setScenario('update');
            $this->submission->setAttributes($_POST['Submission']);
            $this->submission->save();
        }
        $this->render('submissionupdate', array(
            'submission' => $this->submission,
        ));
    }
    
}