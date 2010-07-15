<?php
class Sandbox {
    
    public static function execute($parameter, $command, &$output, &$retval = NULL) {
        $output = "";
        $moeval_path = Yii::app()->params->config['evaluator']['sandbox']['moevalbox_path'];
        $exec = sprintf("%s %s -- %s", $moeval_path, $parameter, $command);
        //$executelastline = exec($exec." 2>&1", $execoutput, $retval);
        printf("%s\n", $exec);
        $execoutput = array();
        $execoutput = implode("\n", $execoutput);
        if (strpos($executelastline, "Time limit exceeded") !== false){
            throw new SandboxException(SandboxException::ERR_TIMELIMIT_EXCEEDED);
        }
        if (strpos($executelastline, "Forbidden syscall") !== false){
            throw new SandboxException(SandboxException::ERR_FORBIDDEN_SYSCALL);
        }
        if (strpos($executelastline, "File access forbidden") !== false){
            throw new SandboxException(SandboxException::ERR_FORBIDDEN_ACCESS);
        }
        if (strpos(strtolower($execoutput), "Out of memory") !== false){
            throw new SandboxException(SandboxException::ERR_TIMELIMIT_EXCEEDED);
        }
        if (strpos($execoutput, "Out of memory") !== false){
            throw new SandboxException(SandboxException::ERR_TIMELIMIT_EXCEEDED);
        }
        if (strpos($execoutput, "virtual memory exhausted") !== false){
            throw new SandboxException(SandboxException::ERR_TIMELIMIT_EXCEEDED);
        }
        $output = $execoutput;
        return $retval;
    }

    public static function getTempName($prefix = NULL){
        $tempdir = Yii::app()->params->config['evaluator']['evaluator']['sandbox_temp_dir'];
        $prefix = (!is_null($prefix)) ? $prefix : '';
        $path = tempnam($tempdir, $prefix);
        return $path;
    }
}
