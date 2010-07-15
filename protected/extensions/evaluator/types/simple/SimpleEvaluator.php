<?php

Yii::import("ext.evaluator.base.EvaluatorBase");

class SimpleEvaluator extends EvaluatorBase {
    
    private $mSourcePath , $mTestcasePath , $mConfigPath , $mSourceLang , $key , $tcno;
    private $result;

    public function __construct($key , $pSourcePath = "" , $pTestcasePath = "" , $pConfigPath = "") {
        $this->mSourcePath = $pSourcePath;
        $this->mTestcasePath = $pTestcasePath;
        $this->mConfigPath = $pConfigPath;
        $this->result = new stdClass();
        $this->key = $key;
        
        $tConfig = json_decode(file_get_contents($pConfigPath) , true);
        $this->memoryLimit = $tConfig["memorylimit"];
        $this->timeLimit = $tConfig["timelimit"];
        $this->tcno = $tConfig["testcaseno"];
        
        $tokens = explode("." , $pSourcePath);
        $this->mSourceLang = $tokens[count($tokens) - 1];
    }
    
    protected function compile() {
        $source_path = Sandbox::getTempName();
        file_put_contents($source_path, file_get_contents($this->mSourcePath));
        $compiler_output = "";
        
        try {
            $execpath = Compiler::compile($source_path, $this->mSourceLang, NULL, NULL, $compiler_output);
            $this->result->compileoutput = $compiler_output;
        } catch (CompilerException $ex) {
            $this->result->verdict = "Compile Error";
            $this->result->compileoutput = $compiler_output;
            $execpath = "";
        }
        
        if (!defined("EVALUATOR_DEBUG"))
            unlink($source_path);
        
        $this->execpath = $execpath;
    }
    
    protected function run($testcase) {
        $this->inputpath = $testcase['input'];
        $this->outputpath = $testcase['output'];
        $this->tmpoutput = Sandbox::getTempName();
        $wallTimeLimit = $this->timeLimit * 3;
        $sandboxparam = "-e -f -a 2 -t $this->timeLimit -w $wallTimeLimit -m $this->memoryLimit -i $this->inputpath -o $this->tmpoutput";
        $execoutput = "";
        Sandbox::execute($sandboxparam, $this->execpath, $execoutput);

        return $execoutput;
    }
    
    protected function evaluateOutput(&$score) {
        if (/*!$this->usingCustomGrader*/true) {
            $retval = Comparator::compare_file($this->tmpoutput, $this->outputpath);
            $score = 1;
        }/* else {
            $runpath = str_replace('[PROBLEM_PATH]', $this->problem->getFile('evaluator/'), $this->problem->getConfig('command_line'));
            $runpath = str_replace('[OUTPUT]', $this->tmpoutput, $runpath);
            $runpath = str_replace('[INPUT]', $this->inputpath, $runpath);
            $runpath = str_replace('[OUTPUT_KEY]', $this->outputpath, $runpath);

            //echo $runpath . "\n";
            $result = array();
            exec($runpath, $result);
            //print_r($result);

            if ($result[0] == "[OK]") {
                $retval = true;
                $score = isset($result[1]) ? $result[1] / 100 : 1;
            } else {
                $retval = false;
            }
        }*/

        return $retval;
    }
    
    protected function execute() {
        //TODO: Implement unzipping
        
        $summary = "";
        $righttc = 0;
        $runtimerror = 0;
        
        for ($i = 1 ; $i <= $this->tcno ; $i++) {
            $input = $this->mTestcasePath . "/" . $this->key . $i . ".in";
            $outputkey = $this->mTestcasePath . "/" . $this->key . $i . ".out";
            
            $testcase["input"] = $input;
            $testcase["output"] = $outputkey;
            
            $summary .= "Testcase #" . $i . "\n\t";
            
            try {
                $execoutput = $this->run($testcase);
                $summary .= $execoutput;
                
                $score = 0;
                if ($this->evaluateOutput($score)) {
                    $summary .= "\n\t" . "Accepted";
                    $righttc++;
                }
                else {
                    $summary .= "\n\t" . "Wrong answer";
                }
            }
            catch (SandboxException $ex) {
                $summary .= "Runtime Error : " . $ex->getMessage();
                $runtimerror++;
            }
            
            $summary .= "\n";
         
            if (file_exists($this->tmpoutput) && !defined("EVALUATOR_DEBUG"))
                unlink($this->tmpoutput);
        }
        
        $this->result->executionsummary = $summary;
        $this->result->totaltc = $this->tcno;
        $this->result->successfultc = $righttc;
        $this->result->runtimeerror = $runtimerror;
    }
    
    public function getResult() {
        return $this->result;
    }
    
    public function doCompile() {
        $this->compile();
    }
    
    public function doExecute() {
        $this->execute();
    }
    
    public function cleanup() {
        unlink($this->execpath);
    }

}

?>
