<?php

Yii::import("ext.evaluator.base.EvaluatorBase");

class BatchioiEvaluator extends EvaluatorBase {
    
    public function doEvaluate() {
        self::evaluate($this->submission);
    }

    public static function evaluate($submission){
        //define("EVALUATOR_DEBUG", true);
        $problem = $submission->problem;
        $time_limit = $problem->getConfig('time_limit') / 1000;
        $memory_limit = $problem->getConfig('memory_limit') / 1024;
        $testcases = $problem->getConfig('testcases');

        $cids = explode(" " , $problem->getConfig('sample_contest'));

        $isSampleOnly = in_array($submission->contest_id, $cids) && $submission->contest_id !== NULL;

        //echo $isSampleOnly;

        //Compile
        $source_content = $submission->getSubmitContent('source_content');
        $source_lang = $submission->getSubmitContent('source_lang');
        $source_path = Sandbox::getTempName();
        file_put_contents($source_path, $source_content);
        $compiler_output = "";
        try {
            $execpath = Compiler::compile($source_path, $source_lang, NULL, NULL, $compiler_output);
        } catch (CompilerException $ex) {
            $submission->setGradeContent("verdict", "Compile Error");
            $submission->setGradeContent("output", $compiler_output);
            if (!defined("EVALUATOR_DEBUG")) unlink($source_path);
            return;
        }
        if (!defined("EVALUATOR_DEBUG")) unlink($source_path);
        //Execute
        $isruntimeok = true;
        $istimelimit = false;
        $rightoutput = true;
        $err = "";
        $output = "";
        $i = 1;
        $total_testcase = 0;
        $right_testcase = 0;
        foreach($testcases as $testcase)
        {
            if (!isset($testcase['sample']))
                continue;

            $total_testcase++;
            $output .= "Testcase #" .$i . " in: " . $testcase['input'] . " out: " . $testcase['output'] . "\n";
            $i++;
            $inputpath = $problem->getFile('evaluator/files/'.$testcase['input']);
            $outputpath = $problem->getFile('evaluator/files/'.$testcase['output']);
            $tmpoutput = Sandbox::getTempName();
            $sandboxparam = "-e -f -a 2 -t $time_limit -m $memory_limit -i $inputpath -o $tmpoutput";
            $execoutput = "";
            try {
                Sandbox::execute($sandboxparam, $execpath, $execoutput);
                $tc_score = 0;
                if (strlen($execoutput) > 0) {
                    $output .= "\t".str_replace("\n", "\n\t", $execoutput)."\n";
                }

                if ($problem->getConfig('command_line') == '') {
                    $retval = Comparator::compare_file($tmpoutput, $outputpath);
                    $tc_score = 1;
                }
                else {
                    $runpath = str_replace('[PROBLEM_PATH]' , $problem->getFile('evaluator/files/') , $problem->getConfig('command_line'));
                    $runpath = str_replace('[OUTPUT]' , $tmpoutput , $runpath);
                    $runpath = str_replace('[INPUT]' , $inputpath , $runpath);
                    $runpath = str_replace('[OUTPUT_KEY]' , $outputpath , $runpath);

                    echo $runpath . "\n";
                    $result = array();
                    exec($runpath , $result);
                    print_r($result);

                    if ($result[0] == "[OK]") {
                        $retval = true;
                        $tc_score = isset($result[1]) ? $result[1] / 100 : 1;
                    }
                    else {
                        $retval = false;
                    }
                    
                }
                if ($retval) {
                        $output .= "\tAccepted [Score : ". $tc_score * 100 ."]\n";
                        $right_testcase+=$tc_score;
                        $rightoutput = $rightoutput && TRUE;
                }
                else {
                        $output .= "\tWrong Answer [Score : 0]\n";
                        $rightoutput = $rightoutput && FALSE;
                }
            } catch (SandboxException $ex){
                    $isruntimeok = false;
                    if ($ex->status == SandboxException::ERR_TIMELIMIT_EXCEEDED)
                    {
                            $istimelimit = true;
                    }
                    $output .= "\t".$ex->getMessage()."\n";
                    $err = $ex->getMessage();
                    continue;
            }
            if (file_exists($tmpoutput) && !defined("EVALUATOR_DEBUG")) unlink($tmpoutput);
        }
        $verdict = ($isruntimeok) ? (($rightoutput) ? "Accepted" : "Wrong Answer") : ($err);
        $submission->verdict = $verdict;
        $submission->setGradeContent("verdict", $verdict);
        $submission->setGradeContent("output", $output);
        $submission->setGradeContent("total_testcase", $total_testcase);
        $submission->setGradeContent("right_testcase", $right_testcase);
        $submission->score = ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100);


        //Execute official TC
        $isruntimeok = true;
        $istimelimit = false;
        $rightoutput = true;
        $err = "";
        $output = "";
        $i = 1;
        $total_testcase = 0;
        $right_testcase = 0;
        foreach($testcases as $testcase)
        {
            if (isset($testcase['sample']))
                continue;

            $total_testcase++;
            $output .= "Testcase #" .$i . "\n\tin : " . $testcase['input'] . " out: " . $testcase['output'] . "\n";
            $i++;
            $inputpath = $problem->getFile('evaluator/files/'.$testcase['input']);
            $outputpath = $problem->getFile('evaluator/files/'.$testcase['output']);
            $tmpoutput = Sandbox::getTempName();
            $sandboxparam = "-e -f -a 2 -t $time_limit -m $memory_limit -i $inputpath -o $tmpoutput";
            $execoutput = "";
            try {
                Sandbox::execute($sandboxparam, $execpath, $execoutput);
                $tc_score = 0;
                if (strlen($execoutput) > 0) {
                    $output .= "\t".str_replace("\n", "\n\t", $execoutput)."\n";
                }

                if ($problem->getConfig('command_line') == '') {
                    $retval = Comparator::compare_file($tmpoutput, $outputpath);
                    $tc_score = 1;
                }
                else {
                    $runpath = str_replace('[PROBLEM_PATH]' , $problem->getFile('evaluator/files/') , $problem->getConfig('command_line'));
                    $runpath = str_replace('[OUTPUT]' , $tmpoutput , $runpath);
                    $runpath = str_replace('[INPUT]' , $inputpath , $runpath);
                    $runpath = str_replace('[OUTPUT_KEY]' , $outputpath , $runpath);

                    echo $runpath . "\n";
                    $result = array();
                    exec($runpath , $result);
                    print_r($result);

                    if ($result[0] == "[OK]") {
                        $retval = true;
                        $tc_score = isset($result[1]) ? $result[1] / 100 : 1;
                    }
                    else {
                        $retval = false;
                    }

                }
                if ($retval) {
                        $output .= "\tAccepted [Score : ". $tc_score * 100 ."]\n";
                        $right_testcase+=$tc_score;
                        $rightoutput = $rightoutput && TRUE;
                }
                else {
                        $output .= "\tWrong Answer [Score : 0]\n";
                        $rightoutput = $rightoutput && FALSE;
                }
            } catch (SandboxException $ex){
                    $isruntimeok = false;
                    if ($ex->status == SandboxException::ERR_TIMELIMIT_EXCEEDED)
                    {
                            $istimelimit = true;
                    }
                    $output .= "\t".$ex->getMessage()."\n";
                    $err = $ex->getMessage();
                    continue;
            }
            if (file_exists($tmpoutput) && !defined("EVALUATOR_DEBUG")) unlink($tmpoutput);
        }

        if (!$isSampleOnly) {
            $verdict = ($isruntimeok) ? (($rightoutput) ? "Accepted" : "Wrong Answer") : ($err);
            $submission->verdict = $verdict;
            $submission->setGradeContent("verdict", $verdict);
            $submission->setGradeContent("output", $output);
            $submission->setGradeContent("total_testcase", $total_testcase);
            $submission->setGradeContent("right_testcase", $right_testcase);
            $submission->score = ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100);
        }
        else {
            $submission->setGradeContent("official_result", ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100));
            $submission->setGradeContent("official_output", $output);
        }

        if (file_exists($execpath) && !defined("EVALUATOR_DEBUG")) unlink($execpath);

    }
    
}
