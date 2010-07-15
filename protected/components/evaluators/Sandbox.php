<?php

class Sandbox {

    public static function execute($parameter, $command, &$output, &$retval = NULL) {
        $output = "";
        $tmperr = self::getTempName();
        $moeval_path = Yii::app()->params->config['evaluator']['sandbox']['moevalbox_path'];
        $exec = sprintf("%s %s -r %s -- %s", $moeval_path, $parameter, $tmperr, $command);
        if (!defined("EVALUATOR_DEBUG"))
            $executelastline = exec($exec . " 2>&1", $execoutput, $retval);
        //printf("%s\n", $exec);
        $execoutput = implode("\n", $execoutput);
        $errstr = file_get_contents($tmperr);
        $errstr = substr($errstr, 0, 100);
        //$execoutput = $execoutput;
        if (file_exists($tmperr))
            unlink($tmperr);
        $errcode = self::checkOutputError($execoutput);
        if ($errcode != -1)
            throw new SandboxException($errcode);

        $output = $execoutput;
        return $retval;
    }

    public static function plainExecute($pExecCommand, &$pOutput) {
        exec($pExecCommand, $output, $retval);
        $plainOutput = implode("\n", $output);
        $errcode = self::checkOutputError($plainOutput);
        if ($errcode != -1 || $retval != 0)
            throw new SandboxException($errcode, $plainOutput);
        $pOutput = $plainOutput;
        return $retval;
    }

    private static function getErrors() {
        return array(
            SandboxException::ERR_FORBIDDEN_SYSCALL => array(
                "Forbidden syscall"
            ),
            SandboxException::ERR_RUNTIME_ERROR => array(
                "Caught fatal signal 11",
                "Committed suicide by signal 6"
            ),
            SandboxException::ERR_TIMELIMIT_EXCEEDED => array(
                "Time limit exceeded"
            ),
            SandboxException::ERR_MEMORYLIMIT_EXCEEDED => array(
                "Caught fatal signal 9",
                "Out of memory",
                "out of memory",
                "virtual memory exhausted"
            ),
            SandboxException::ERR_FORBIDDEN_ACCESS => array(
                "File access forbidden"
            )
        );
    }

    private static function checkOutputError($output) {
        $array = self::getErrors();
        $errorcode = -1;
        foreach ($array as $key => $errorstrings) {
            foreach ($errorstrings as $errorstr) {
                if (strpos($output, $errorstr) !== false) {
                    $errorcode = $key;
                    break;
                }
            }
            if ($errorcode != -1)
                break;
        }
        return $errorcode;
    }

    public static function getTempName($prefix = NULL) {
        $tempdir = Yii::app()->params->config['evaluator']['evaluator']['sandbox_temp_dir'];
        $prefix = (!is_null($prefix)) ? $prefix : '';
        $path = tempnam($tempdir, $prefix);
        return $path;
    }

}
