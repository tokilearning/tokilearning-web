<?php

Yii::import("ext.evaluator.base.StandardSubmissionUpdateWidgetBase");

class SimpletextSubmissionUpdateWidget extends StandardSubmissionUpdateWidgetBase {

    public function run(){
        $this->processPost();
        $this->render('submissionupdate', array(
            'submission' => $this->submission,
        ));
    }
    
}