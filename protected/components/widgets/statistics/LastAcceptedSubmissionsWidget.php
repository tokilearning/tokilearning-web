<?php

class LastAcceptedSubmissionsWidget extends CWidget {

    public $count = 5;

    public function run() {
        $this->render('lastacceptedsubmissions');
    }

}