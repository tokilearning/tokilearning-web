<?php

abstract class CoreExecutor {

    private $sandbox;

    public function setSandbox($sandbox) {
        $this->sandbox = $sandbox;
    }

    public abstract function execute($execPath, $parameter, $stdin = '', &$stdout = '', &$stderr = '');
}