<?php

class EvaluatorBase {

    protected $problem;
    protected $timeLimit;
    protected $memoryLimit;
    protected $testCases;
    protected $submission;
    protected $execpath;

    public function __construct($pSubmission) {
        $this->submission = $pSubmission;
        $this->problem = $pSubmission->problem;
        $this->timeLimit = $this->problem->getConfig('time_limit') / 1000;
        $this->memoryLimit = $this->problem->getConfig('memory_limit') / 1000;
        $this->testCases = $this->problem->getConfig('testcases');
    }

    protected function beforeCompile() {
        
    }
    
    public function getSubmissionRemarks() {
        
    }

    protected function compile() {
        $this->beforeCompile();

        $source_content = $this->submission->getSubmitContent('source_content');
        $source_lang = $this->submission->getSubmitContent('source_lang');
        $source_path = Sandbox::getTempName();
        file_put_contents($source_path, $source_content);
        $compiler_output = "";
        try {
            $execpath = Compiler::compile($source_path, $source_lang, NULL, NULL, $compiler_output);
        } catch (CompilerException $ex) {
            $this->submission->verdict = "Compile Error";
            $this->submission->setGradeContent("verdict", "Compile Error");
            $this->submission->setGradeContent("output", $compiler_output);
            $execpath = "";
        }
        if (!defined("EVALUATOR_DEBUG"))
            unlink($source_path);

        $this->execpath = $execpath;
        return $this->execpath;
    }

    protected function beforeExecute() {
        
    }

    protected function execute() {
        $this->beforeExecute();
    }

    public function doEvaluate() {
        echo "Exec path : " . $this->compile() . "\n";

        if ($this->execpath != "") {
            $this->execute();
            unlink($this->execpath);
        }
    }

    public function getTestCases() {
        return $this->testCases;
    }

}

?>
