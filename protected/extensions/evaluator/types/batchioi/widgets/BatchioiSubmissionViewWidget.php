<?php


class BatchioiSubmissionViewWidget extends CWidget {

    public $submission;
    public $viewLevel = 0; //0, 1, 2

    public function run(){
        $this->render('submissionview', array(
            'submission' => $this->submission,
            'viewLevel' => $this->viewLevel,
        ));
    }
    
}