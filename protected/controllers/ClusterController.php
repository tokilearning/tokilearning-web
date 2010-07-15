<?php

Yii::import("application.components.evaluators.*");

class ClusterController extends CPublicController {
    private static $path = "/var/tokilx/prod/shadowproblems/problems/";

    public function actionGrade() {
        if (isset($_POST['payload']) && isset($_POST['key']) && $_POST['key'] == "KD") {
            //print_r(json_decode($_POST['payload'] , true));
            echo json_encode($this->grade(json_decode($_POST['payload'] , true)));
        }
        else {
            echo "Failed";
        }
    }

    private function grade($pPayload) {
        $result = array();
        $result['verdict'] = "OK";
        $useCustomChecker = false;

        ///Init problem path
        $path = self::$path . $pPayload['token'] . "/evaluator/files/";

        ///Init constraint
        $timeLimit = $pPayload['time_limit'] / 1000;
        $memoryLimit = $pPayload['memory_limit'];
        $testcases = $pPayload['testcases'];

        ///Compile checker
        if ($pPayload['checker_source'] != "") {
            $useCustomChecker = true;

            $checkerSourcePath = $path . $pPayload['checker_source'];
            $checkerExecPath = $path . "grader";

            exec("g++ -o " . $checkerExecPath . " " . $checkerSourcePath);
        }

        ///Compile source
        $language = $pPayload['language'];
        $source = $pPayload['source'];
        $sourcePath = Sandbox::getTempName();
        file_put_contents($sourcePath, $source);

        try {
            $execPath = Compiler::compile($sourcePath , $language , NULL , NULL , $compilerOutput);
        }
        catch(CompilerException $ex) {
            $result['verdict'] = "Compile error";
        }

        if ($result['verdict'] != "Compile error") {
            foreach ($testcases as $key => $testcase) {
                $inputpath = $path . $testcase['input'];
                $outputkeypath = $path . $testcase['output'];

                $tmpoutput = Sandbox::getTempName();
                $sandboxparam = "-e -f -a 2 -t $timeLimit -m $memoryLimit -i $inputpath -o $tmpoutput";

                try {
                    Sandbox::execute($sandboxparam, $execPath, $execoutput);
                    $ok = false;
                    $result['testcases'][$key]['output'] = $execoutput;

                    if ($useCustomChecker) {
                        $checkerRunCommand = $pPayload['checker_run_command'];

                        $checkerRunCommand = str_replace('[PROBLEM_PATH]' , $path , $checkerRunCommand);
                        $checkerRunCommand = str_replace('[OUTPUT]' , $tmpoutput , $checkerRunCommand);
                        $checkerRunCommand = str_replace('[INPUT]' , $inputpath , $checkerRunCommand);
                        $checkerRunCommand = str_replace('[OUTPUT_KEY]' , $outputkeypath , $checkerRunCommand);

                        $compareResult = array();
                        exec($checkerRunCommand , $compareResult);
                        //print_r($compareResult);

                        if ($compareResult[0] == "[OK]") {
                            $ok = true;
                            if (isset($compareResult[1]))
                                $result['testcases'][$key]['score'] = $compareResult[1];
                        }
                        else {
                            $ok = false;
                        }
                    }
                    else {
                        $retval = Comparator::compare_file($tmpoutput, $outputkeypath);

                    }

                    if ($ok) {
                        $result['testcases'][$key]['result'] = "OK";
                    }
                    else {
                        $result['testcases'][$key]['result'] = "Failed";
                        $result['testcases'][$key]['reason'] = "Wrong Answer";
                    }

                }
                catch(SandboxException $ex) {
                    $result['testcases'][$key]['result'] = "Failed";
                    if ($ex->status == SandboxException::ERR_TIMELIMIT_EXCEEDED)
                    {
                        $result['testcases'][$key]['reason'] = "Time Limit exceeded";
                    }
                    else {
                        $result['testcases'][$key]['reason'] = "Runtime error: " . $ex->getMessage();
                    }
                }


                unlink($tmpoutput);
            }
        }

        ///Finishing
        unlink($sourcePath);
        if (file_exists($checkerExecPath)) unlink($checkerExecPath);
        if (file_exists($execPath)) unlink($execPath);

        //print_r($result);
        
        return $result;
    }
}

?>
