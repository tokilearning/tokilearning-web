<?php

abstract class ParameterizedWidget extends CWidget {

    public function run() {
        $this->processAction();
        $this->processPost();
    }
    
    protected function processAction() {
        
    }

    protected function processPost() {
        
    }
}

?>
