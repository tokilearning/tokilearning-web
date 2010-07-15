<?php

abstract class CoreCompiler {

    private $sandbox;

    public function setSandbox($sandbox) {
        $this->sandbox = $sandbox;
    }

    public abstract function compile($source_path, $binaryPath, &$output, $parameter = NULL);
}