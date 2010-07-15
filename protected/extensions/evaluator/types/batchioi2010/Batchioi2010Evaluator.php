<?php

Yii::import("ext.evaluator.base.EvaluatorBase");

class Batchioi2010Evaluator extends EvaluatorBase {

    private $usingCustomGrader = false;
    protected $inputpath, $outputpath, $tmpoutput;

    const DEFAULT_BATCH = "default";
    const SAMPLE_BATCH = "sample";

    protected function evaluateOutput(&$score) {
        if (!$this->usingCustomGrader) {
            $retval = Comparator::compare_file($this->tmpoutput, $this->outputpath);
            $score = 1;
        } else {
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
        }

        return $retval;
    }

    protected function isSubmissionFullyReleased() {
        if ($this->submission->contest != null) {
            if ($this->submission->contest->getConfig('secret') != null) {
                return !$this->submission->contest->getConfig('secret');
            }
            else
                return true;
        }
        else
            return false;
    }

    protected function run($testcase) {
        $this->inputpath = $this->problem->getFile('evaluator/files/' . $testcase['input']);
        $this->outputpath = $this->problem->getFile('evaluator/files/' . $testcase['output']);
        $this->tmpoutput = Sandbox::getTempName();
        $wallTimeLimit = $this->timeLimit * 3;
        $sandboxparam = "-e -f -a 2 -t $this->timeLimit -w $wallTimeLimit -m $this->memoryLimit -i $this->inputpath -o $this->tmpoutput";
        $execoutput = "";
        Sandbox::execute($sandboxparam, $this->execpath, $execoutput);

        return $execoutput;
    }

    protected function execute() {
        parent::execute();
        $batchPoints = $this->problem->getConfig('batchpoints');
        $batchPoints[self::SAMPLE_BATCH] = 100;
        $batchStatus = array();
        $problem = $this->problem;

        $right_testcase = 0;
        $total_testcase = 0;
        $isruntimeok = true;
        $istimelimit = false;
        $rightoutput = true;
        $err = "";

        foreach ($this->testCases as $key => $testcase) {
            if (isset($testcase[self::SAMPLE_BATCH]))
                $batch = self::SAMPLE_BATCH;
            else
                $batch = (!isset($testcase['batch']) || $testcase['batch'] == '') ? self::DEFAULT_BATCH : $testcase['batch'];

            if (!isset($batchStatus[$batch]))
                $batchStatus[$batch] = array('total' => 0, 'score' => 0, 'value' => true, 'output' => "", 'runtimeok' => true);
            $batchStatus[$batch]['total']++;

            $batchStatus[$batch]['output'] .= "Testcase #" . $key . "\tBatch " . $batch . "\n\tin : " . $testcase['input'] . " out: " . $testcase['output'] . "\n";

            if ($batch != self::SAMPLE_BATCH && $batch != self::DEFAULT_BATCH && !$batchStatus[$batch]['value']) {
                $batchStatus[$batch]['output'] .= "\tTestcase skipped\n";
                continue;
            }

            try {
                $execoutput = $this->run($testcase);
                $tc_score = 0;
                if (strlen($execoutput) > 0) {
                    $batchStatus[$batch]['output'] .= "\t" . str_replace("\n", "\n\t", $execoutput) . "\n";
                }

                $retval = $this->evaluateOutput($tc_score);

                if ($retval) {
                    $batchStatus[$batch]['output'] .= "\tAccepted [Score : " . $tc_score * 100 . "]\n";
                    $right_testcase+=$tc_score;
                    $batchStatus[$batch]['score'] += $tc_score;
                    $rightoutput = $rightoutput && TRUE;
                } else {
                    $batchStatus[$batch]['output'] .= "\tWrong Answer [Score : 0]\n";
                    $rightoutput = $rightoutput && FALSE;
                    $batchStatus[$batch]['value'] = false;
                }
            } catch (SandboxException $ex) {
                $isruntimeok = false;
                if ($ex->status == SandboxException::ERR_TIMELIMIT_EXCEEDED) {
                    $istimelimit = true;
                }
                $batchStatus[$batch]['runtimeok'] = false;
                $batchStatus[$batch]['output'] .= "\t" . $ex->getMessage() . "\n";
                $batchStatus[$batch]['err'] = $ex->getMessage();
                $batchStatus[$batch]['value'] = false;
                //continue;
            }
            if (file_exists($this->tmpoutput) && !defined("EVALUATOR_DEBUG"))
                unlink($this->tmpoutput);
        }

        ///Sample
        $submission = $this->submission;
        $verdict = "";
        if ($batchStatus[self::SAMPLE_BATCH]['value'])
            $verdict = "Accepted";
        else if (!$batchStatus[self::SAMPLE_BATCH]['runtimeok'])
            $verdict = $batchStatus[self::SAMPLE_BATCH]['err'];
        else
            $verdict = "Wrong Answer";

        $submission->verdict = $verdict;
        $submission->setGradeContent('output', $batchStatus[self::SAMPLE_BATCH]['output']);
        $submission->setGradeContent("total_testcase", 1);
        $submission->setGradeContent("right_testcase", 1);
        $submission->score = ($batchStatus[self::SAMPLE_BATCH]['value']) ? $batchPoints[self::SAMPLE_BATCH] : 0;

        ///Official
        $officialOutput = "";
        $officialScore = 0;
        foreach ($batchStatus as $batch => $status) {
            if ($batch == self::DEFAULT_BATCH) {
                $officialOutput .= "============================\n" . "Default Scoring" . "\n============================\n" . $status['output'];
                $officialScore += $status['score'] / $status['total'] * 100;
                echo $batchPoints[$batch];
            } else if ($batch != self::SAMPLE_BATCH) {
                $officialOutput .= "============================\n" . "Batch #" . $batch . "\n============================\n" . $status['output'];
                if ($status['value']) {
                    $officialScore += $status['score'] / $status['total'] * $batchPoints[$batch];
                }
            }
        }

        $submission->setGradeContent("official_result", $officialScore);
        $submission->setGradeContent("official_output", $officialOutput);
    }

    protected function beforeCompile() {
        ///Prepare grader
        $sourceFile = $this->problem->getFile('evaluator/files/' . $this->problem->getConfig('checker_source'));
        $graderFile = $this->problem->getFile('evaluator/') . '/grader';

        //echo $sourceFile . " " . $graderFile;
        //echo filemtime($sourceFile) ." ". filemtime($graderFile);
        ///Compiles checker
        if (file_exists($sourceFile) && file_exists($graderFile) && filemtime($sourceFile) > filemtime($graderFile) || !file_exists($graderFile)) {
            $checkerSource = $sourceFile;
            $checkerOutput = $graderFile;

            echo "g++ -o " . $checkerOutput . " " . $checkerSource . "\n";
            exec("g++ -o " . $checkerOutput . " " . $checkerSource);
        }

        if ($this->problem->getConfig('checker_source') != "" && file_exists($sourceFile))
            $this->usingCustomGrader = true;
    }

    public static function evaluateCluster($submission, $problem, $problemtype) {
        $time_limit = $problem->getConfig('time_limit') / 1000;
        $memory_limit = $problem->getConfig('memory_limit') / 1024;
        $testcases = $problem->getConfig('testcases');

        $cids = explode(" ", $problem->getConfig('sample_contest'));

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
            if (!defined("EVALUATOR_DEBUG"))
                unlink($source_path);
            return;
        }
        if (!defined("EVALUATOR_DEBUG"))
            unlink($source_path);
        //Execute
        $isruntimeok = true;
        $istimelimit = false;
        $rightoutput = true;
        $err = "";
        $output = "";
        $i = 1;
        $total_testcase = 0;
        $right_testcase = 0;
        $batchValue = array();
        foreach ($testcases as $testcase) {
            if (!isset($testcase[self::SAMPLE_BATCH]))
                continue;

            $batch = (!isset($testcase['batch']) || $testcase['batch'] == '') ? 'default' : $testcase['batch'];
            if (!isset($batchValue[$batch]))
                $batchValue[$batch] = array('total' => 0, 'score' => 0, 'value' => true);
            $batchValue[$batch]['total']++;

            $total_testcase++;
            $output .= "Testcase #" . $i . "\tBatch " . $batch . "\n\tin : " . $testcase['input'] . " out: " . $testcase['output'] . "\n";

            if (!$batchValue[$batch]['value']) {
                $output .= "\tTestcase skipped\n";
                continue;
            }

            $i++;
            $inputpath = $problem->getFile('evaluator/files/' . $testcase['input']);
            $outputpath = $problem->getFile('evaluator/files/' . $testcase['output']);
            $tmpoutput = Sandbox::getTempName();
            $sandboxparam = "-e -f -a 2 -w $time_limit -m $memory_limit -i $inputpath -o $tmpoutput";
            $execoutput = "";
            try {
                Sandbox::execute($sandboxparam, $execpath, $execoutput);
                $tc_score = 0;
                if (strlen($execoutput) > 0) {
                    $output .= "\t" . str_replace("\n", "\n\t", $execoutput) . "\n";
                }

                if ($problem->getConfig('command_line') == '') {
                    $retval = Comparator::compare_file($tmpoutput, $outputpath);
                    $tc_score = 1;
                } else {
                    $runpath = str_replace('[PROBLEM_PATH]', $problem->getFile('evaluator/files/'), $problem->getConfig('command_line'));
                    $runpath = str_replace('[OUTPUT]', $tmpoutput, $runpath);
                    $runpath = str_replace('[INPUT]', $inputpath, $runpath);
                    $runpath = str_replace('[OUTPUT_KEY]', $outputpath, $runpath);

                    echo $runpath . "\n";
                    $result = array();
                    exec($runpath, $result);
                    print_r($result);

                    if ($result[0] == "[OK]") {
                        $retval = true;
                        $tc_score = isset($result[1]) ? $result[1] / 100 : 1;
                    } else {
                        $retval = false;
                    }
                }
                if ($retval) {
                    $output .= "\tAccepted [Score : " . $tc_score * 100 . "]\n";
                    $right_testcase+=$tc_score;
                    $batchValue[$batch]['score'] += $tc_score;
                    $rightoutput = $rightoutput && TRUE;
                } else {
                    $output .= "\tWrong Answer [Score : 0]\n";
                    $rightoutput = $rightoutput && FALSE;
                    $batchValue[$batch]['value'] = false;
                }
            } catch (SandboxException $ex) {
                $isruntimeok = false;
                if ($ex->status == SandboxException::ERR_TIMELIMIT_EXCEEDED) {
                    $istimelimit = true;
                }
                $output .= "\t" . $ex->getMessage() . "\n";
                $err = $ex->getMessage();
                continue;
            }
            if (file_exists($tmpoutput) && !defined("EVALUATOR_DEBUG"))
                unlink($tmpoutput);
        }
        $right_testcase = 0;
        $batchPoints = $problem->getConfig('batchpoints');
        $batchScore = 0;
        foreach ($batchValue as $key => $b) {
            if ($b['value']) {
                //$right_testcase += $b['score'];
                if (isset($batchPoints[$key]))
                    $batchScore += $batchPoints[$key];
            }
        }
        $verdict = ($isruntimeok) ? (($rightoutput) ? "Accepted" : "Wrong Answer") : ($err);
        $submission->verdict = $verdict;
        $submission->setGradeContent("verdict", $verdict);
        $submission->setGradeContent("output", $output);
        $submission->setGradeContent("total_testcase", $total_testcase);
        $submission->setGradeContent("right_testcase", $right_testcase);
        //$submission->score = ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100);
        $submission->score = $batchScore;


        //Execute official TC
        $isruntimeok = true;
        $istimelimit = false;
        $rightoutput = true;
        $err = "";
        $output = "";
        $i = 1;
        $total_testcase = 0;
        $right_testcase = 0;
        $batchValue = array();
        foreach ($testcases as $testcase) {
            if (isset($testcase[self::SAMPLE_BATCH]))
                continue;

            $batch = (!isset($testcase['batch']) || $testcase['batch'] == '') ? 'default' : $testcase['batch'];
            if (!isset($batchValue[$batch]))
                $batchValue[$batch] = array('total' => 0, 'score' => 0, 'value' => true);
            $batchValue[$batch]['total']++;

            $total_testcase++;
            $output .= "Testcase #" . $i . "\tBatch " . $batch . "\n\tin : " . $testcase['input'] . " out: " . $testcase['output'] . "\n";
            $i++;
            $inputpath = $problem->getFile('evaluator/files/' . $testcase['input']);
            $outputpath = $problem->getFile('evaluator/files/' . $testcase['output']);
            $tmpoutput = Sandbox::getTempName();
            $sandboxparam = "-e -f -a 2 -w $time_limit -m $memory_limit -i $inputpath -o $tmpoutput";
            $execoutput = "";
            try {
                Sandbox::execute($sandboxparam, $execpath, $execoutput);
                $tc_score = 0;
                if (strlen($execoutput) > 0) {
                    $output .= "\t" . str_replace("\n", "\n\t", $execoutput) . "\n";
                }

                if ($problem->getConfig('command_line') == '') {
                    $retval = Comparator::compare_file($tmpoutput, $outputpath);
                    $tc_score = 1;
                } else {
                    $runpath = str_replace('[PROBLEM_PATH]', $problem->getFile('evaluator/files/'), $problem->getConfig('command_line'));
                    $runpath = str_replace('[OUTPUT]', $tmpoutput, $runpath);
                    $runpath = str_replace('[INPUT]', $inputpath, $runpath);
                    $runpath = str_replace('[OUTPUT_KEY]', $outputpath, $runpath);

                    echo $runpath . "\n";
                    $result = array();
                    exec($runpath, $result);
                    print_r($result);

                    if ($result[0] == "[OK]") {
                        $retval = true;
                        $tc_score = isset($result[1]) ? $result[1] / 100 : 1;
                    } else {
                        $retval = false;
                    }
                }
                if ($retval) {
                    $output .= "\tAccepted [Score : " . $tc_score * 100 . "]\n";
                    $right_testcase+=$tc_score;
                    $batchValue[$batch]['score'] += $tc_score;
                    $rightoutput = $rightoutput && TRUE;
                } else {
                    $output .= "\tWrong Answer [Score : 0]\n";
                    $rightoutput = $rightoutput && FALSE;
                    $batchValue[$batch]['value'] = false;
                }
            } catch (SandboxException $ex) {
                $isruntimeok = false;
                if ($ex->status == SandboxException::ERR_TIMELIMIT_EXCEEDED) {
                    $istimelimit = true;
                }
                $output .= "\t" . $ex->getMessage() . "\n";
                $err = $ex->getMessage();
                continue;
            }
            if (file_exists($tmpoutput) && !defined("EVALUATOR_DEBUG"))
                unlink($tmpoutput);
        }
        $right_testcase = 0;
        foreach ($batchValue as $b) {
            if ($b['value']) {
                $right_testcase += $b['score'];
            }
        }
        if (!$isSampleOnly/* || $submission->getSubmitContent('fullfeedback') !== null */) {
            echo "FULL FEEDBACK\n";
            $verdict = ($isruntimeok) ? (($rightoutput) ? "Accepted" : "Wrong Answer") : ($err);
            $submission->verdict = $verdict;
            $submission->setGradeContent("verdict", $verdict);
            $submission->setGradeContent("output", $output);
            $submission->setGradeContent("total_testcase", $total_testcase);
            $submission->setGradeContent("right_testcase", $right_testcase);
            $submission->score = ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100);
        } else {
            $submission->setGradeContent("official_result", ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100));
            $submission->setGradeContent("official_output", $output);
        }

        if (file_exists($execpath) && !defined("EVALUATOR_DEBUG"))
            unlink($execpath);
    }

    public static function evaluateClusterResult($pSubmission, $pResult) {
        if ($pResult['verdict'] != "OK") {
            $pSubmission->verdict = "Compile error";
            $pSubmission->score = 0;
            $pSubmission->setGradeContent('official_result', 0);
            return;
        }


        if ($pSubmission->contest !== null) {
            //$cids = explode(" " , $problem->getConfig('sample_contest'));
            //$isSampleOnly = in_array($submission->contest_id, $cids) && $submission->contest_id !== NULL;
            $isSampleOnly = ($pSubmission->contest->contesttype->name == "ioi2010") && ($pSubmission->contest->getConfig('secret'));
        }
        else
            $isSampleOnly = false;

        $originalTestcases = $pSubmission->problem->getConfig('testcases');

        $sampleBatchValue = array();
        $officialBatchValue = array();

        $tcOutput = "";

        foreach ($pResult['testcases'] as $key => $testcase) {
            $origtc = $originalTestcases[$key];

            $tcOutput .= "Testcase #$key\n\tin: " . $origtc['input'] . " out: " . $origtc['output'] . "\n\t" . $testcase['output'] . "\n";

            ///Init batch
            $batch = (!isset($origtc['batch']) || $origtc['batch'] == '') ? $key : $origtc['batch'];

            if (isset($origtc[self::SAMPLE_BATCH])) {
                if (!isset($sampleBatchValue[$batch]))
                    $sampleBatchValue[$batch] = array('right' => true, 'reason' => "");

                if ($testcase['result'] == "OK") {
                    
                } else {
                    $sampleBatchValue[$batch]['right'] = false;
                    $sampleBatchValue[$batch]["reason"] = $testcase["reason"];
                }
            } else {
                if (!isset($officialBatchValue[$batch]))
                    $officialBatchValue[$batch] = array('right' => true, 'reason' => "");

                if ($testcase['result'] == "OK") {
                    
                } else {
                    $officialBatchValue[$batch]['right'] = false;
                    $officialBatchValue[$batch]["reason"] = $testcase["reason"];
                }
            }
        }

        $batchPoints = $pSubmission->problem->getConfig('batchpoints');

        $officialScore = 0;
        $sampleScore = 0;

        $officialOutput = "";
        $sampleOutput = "";

        foreach ($sampleBatchValue as $key => $value) {
            if ($value['right']) {
                $sampleScore += $batchPoints[$key];
                $sampleOutput .= "Subtask #$key OK\n";
            } else {
                $sampleOutput .= "Subtask #$key FAILED: " . $value['reason'] . "\n";
            }
        }

        foreach ($officialBatchValue as $key => $value) {
            if ($value['right']) {
                $officialScore += $batchPoints[$key];
                $officialOutput .= "Subtask #$key OK\n";
            } else {
                $officialOutput .= "Subtask #$key FAILED: " . $value['reason'] . "\n";
            }
        }

        $pSubmission->verdict = "Graded";
        $pSubmission->score = $sampleScore;
        $pSubmission->setGradeContent('output', $sampleOutput);
        $pSubmission->setGradeContent('official_output', $officialOutput);
        $pSubmission->setGradeContent('official_result', $officialScore);
        $pSubmission->setGradeContent('tc_output', $tcOutput);
        //print_r($officialBatchValue);
    }

    public static function evaluate($submission) {
        //define("EVALUATOR_DEBUG", true);
        $problem = $submission->problem;
        $time_limit = $problem->getConfig('time_limit') / 1000;
        $memory_limit = $problem->getConfig('memory_limit') / 1024;
        $testcases = $problem->getConfig('testcases');


        if ($submission->contest !== null) {
            $cids = explode(" ", $problem->getConfig('sample_contest'));
            //$isSampleOnly = in_array($submission->contest_id, $cids) && $submission->contest_id !== NULL;
            $isSampleOnly = ($submission->contest->contesttype->name == "ioi2010") && ($submission->contest->getConfig('secret'));
        }
        else
            $isSampleOnly = false;

        $sourceFile = $problem->getFile('evaluator/files/' . $problem->getConfig('checker_source'));
        $graderFile = $problem->getFile('evaluator/') . '/grader';

        ///Compiles checker
        if ($problem->getConfig('checker_source') != "" && file_exists($sourceFile) && (file_exists($graderFile) && filemtime($sourceFile) > filemtime($graderFile) || !file_exists($graderFile))) {
            $checkerSource = $sourceFile;
            $checkerOutput = $graderFile;

            echo "g++ -o " . $checkerOutput . " " . $checkerSource . "\n";
            exec("g++ -o " . $checkerOutput . " " . $checkerSource);
        }

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
            if (!defined("EVALUATOR_DEBUG"))
                unlink($source_path);
            return;
        }
        if (!defined("EVALUATOR_DEBUG"))
            unlink($source_path);
        //Execute
        $isruntimeok = true;
        $istimelimit = false;
        $rightoutput = true;
        $err = "";
        $output = "";
        $i = 1;
        $total_testcase = 0;
        $right_testcase = 0;
        $batchValue = array();
        foreach ($testcases as $testcase) {
            if (!isset($testcase[self::SAMPLE_BATCH]))
                continue;

            $batch = (!isset($testcase['batch']) || $testcase['batch'] == '') ? 'default' : $testcase['batch'];
            if (!isset($batchValue[$batch]))
                $batchValue[$batch] = array('total' => 0, 'score' => 0, 'value' => true);
            $batchValue[$batch]['total']++;

            $total_testcase++;
            $output .= "Testcase #" . $i . "\tBatch " . $batch . "\n\tin : " . $testcase['input'] . " out: " . $testcase['output'] . "\n";
            $i++;

            if (!$batchValue[$batch]['value']) {
                $output .= "\tTestcase skipped\n";
                continue;
            }

            $inputpath = $problem->getFile('evaluator/files/' . $testcase['input']);
            $outputpath = $problem->getFile('evaluator/files/' . $testcase['output']);
            $tmpoutput = Sandbox::getTempName();
            $sandboxparam = "-e -f -a 2 -t $time_limit -m $memory_limit -i $inputpath -o $tmpoutput";
            $execoutput = "";
            try {
                Sandbox::execute($sandboxparam, $execpath, $execoutput);
                $tc_score = 0;
                if (strlen($execoutput) > 0) {
                    $output .= "\t" . str_replace("\n", "\n\t", $execoutput) . "\n";
                }

                if ($problem->getConfig('command_line') == '') {
                    $retval = Comparator::compare_file($tmpoutput, $outputpath);
                    $tc_score = 1;
                } else {
                    $runpath = str_replace('[PROBLEM_PATH]', $problem->getFile('evaluator/'), $problem->getConfig('command_line'));
                    $runpath = str_replace('[OUTPUT]', $tmpoutput, $runpath);
                    $runpath = str_replace('[INPUT]', $inputpath, $runpath);
                    $runpath = str_replace('[OUTPUT_KEY]', $outputpath, $runpath);

                    //echo $runpath . "\n";
                    $result = array();
                    exec($runpath, $result);
                    //print_r($result);

                    if ($result[0] == "[OK]") {
                        $retval = true;
                        $tc_score = isset($result[1]) ? $result[1] / 100 : 1;
                    } else {
                        $retval = false;
                    }
                }
                if ($retval) {
                    $output .= "\tAccepted [Score : " . $tc_score * 100 . "]\n";
                    $right_testcase+=$tc_score;
                    $batchValue[$batch]['score'] += $tc_score;
                    $rightoutput = $rightoutput && TRUE;
                } else {
                    $output .= "\tWrong Answer [Score : 0]\n";
                    $rightoutput = $rightoutput && FALSE;
                    $batchValue[$batch]['value'] = false;
                }
            } catch (SandboxException $ex) {
                $isruntimeok = false;
                if ($ex->status == SandboxException::ERR_TIMELIMIT_EXCEEDED) {
                    $istimelimit = true;
                }
                $output .= "\t" . $ex->getMessage() . "\n";
                $err = $ex->getMessage();
                $batchValue[$batch]['value'] = false;
                //continue;
            }
            if (file_exists($tmpoutput) && !defined("EVALUATOR_DEBUG"))
                unlink($tmpoutput);
        }
        $right_testcase = 0;
        $batchPoints = $problem->getConfig('batchpoints');
        $batchScore = 0;
        foreach ($batchValue as $key => $b) {
            if ($b['value']) {
                //$right_testcase += $b['score'];
                if (isset($batchPoints[$key]))
                    $batchScore += $batchPoints[$key];
            }
        }
        $verdict = ($isruntimeok) ? (($rightoutput) ? "Accepted" : "Wrong Answer") : ($err);
        $submission->verdict = $verdict;
        $submission->setGradeContent("verdict", $verdict);
        $submission->setGradeContent("output", $output);
        $submission->setGradeContent("total_testcase", $total_testcase);
        $submission->setGradeContent("right_testcase", $right_testcase);
        //$submission->score = ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100);
        $submission->score = $batchScore;


        //Execute official TC
        $isruntimeok = true;
        $istimelimit = false;
        $rightoutput = true;
        $err = "";
        $output = "";
        $i = 1;
        $total_testcase = 0;
        $right_testcase = 0;
        $batchValue = array();
        foreach ($testcases as $testcase) {
            if (isset($testcase[self::SAMPLE_BATCH]))
                continue;

            $batch = (!isset($testcase['batch']) || $testcase['batch'] == '') ? 'default' : $testcase['batch'];
            if (!isset($batchValue[$batch]))
                $batchValue[$batch] = array('total' => 0, 'score' => 0, 'value' => true);
            $batchValue[$batch]['total']++;

            $total_testcase++;
            $output .= "Testcase #" . $i . "\tBatch " . $batch . "\n\tin : " . $testcase['input'] . " out: " . $testcase['output'] . "\n";
            $i++;

            if (!$batchValue[$batch]['value']) {
                $output .= "\tTestcase skipped\n";
                continue;
            }

            $inputpath = $problem->getFile('evaluator/files/' . $testcase['input']);
            $outputpath = $problem->getFile('evaluator/files/' . $testcase['output']);
            $tmpoutput = Sandbox::getTempName();
            $sandboxparam = "-e -f -a 2 -t $time_limit -m $memory_limit -i $inputpath -o $tmpoutput";
            $execoutput = "";
            try {
                Sandbox::execute($sandboxparam, $execpath, $execoutput);
                $tc_score = 0;
                if (strlen($execoutput) > 0) {
                    $output .= "\t" . str_replace("\n", "\n\t", $execoutput) . "\n";
                }

                if ($problem->getConfig('command_line') == '') {
                    $retval = Comparator::compare_file($tmpoutput, $outputpath);
                    $tc_score = 1;
                } else {
                    $runpath = str_replace('[PROBLEM_PATH]', $problem->getFile('evaluator/'), $problem->getConfig('command_line'));
                    $runpath = str_replace('[OUTPUT]', $tmpoutput, $runpath);
                    $runpath = str_replace('[INPUT]', $inputpath, $runpath);
                    $runpath = str_replace('[OUTPUT_KEY]', $outputpath, $runpath);

                    //echo $runpath . "\n";
                    $result = array();
                    exec($runpath, $result);
                    //print_r($result);

                    if ($result[0] == "[OK]") {
                        $retval = true;
                        $tc_score = isset($result[1]) ? $result[1] / 100 : 1;
                    } else {
                        $retval = false;
                    }
                }
                if ($retval) {
                    $output .= "\tAccepted [Score : " . $tc_score * 100 . "]\n";
                    $right_testcase+=$tc_score;
                    $batchValue[$batch]['score'] += $tc_score;
                    $rightoutput = $rightoutput && TRUE;
                } else {
                    $output .= "\tWrong Answer [Score : 0]\n";
                    $rightoutput = $rightoutput && FALSE;
                    $batchValue[$batch]['value'] = false;
                }
            } catch (SandboxException $ex) {
                $isruntimeok = false;
                if ($ex->status == SandboxException::ERR_TIMELIMIT_EXCEEDED) {
                    $istimelimit = true;
                }
                $output .= "\t" . $ex->getMessage() . "\n";
                $err = $ex->getMessage();
                $batchValue[$batch]['value'] = false;
                //continue;
            }
            if (file_exists($tmpoutput) && !defined("EVALUATOR_DEBUG"))
                unlink($tmpoutput);
        }
        $right_testcase = 0;
        $batchPoints = $problem->getConfig('batchpoints');
        $batchScore = 0;
        foreach ($batchValue as $key => $b) {
            if ($b['value']) {
                //$right_testcase += $b['score'];
                if (isset($batchPoints[$key]))
                    $batchScore += $batchPoints[$key];
            }
        }
        if (!$isSampleOnly && false/* || $submission->getSubmitContent('fullfeedback') !== null */) {
            echo "FULL FEEDBACK\n";
            $verdict = ($isruntimeok) ? (($rightoutput) ? "Accepted" : "Wrong Answer") : ($err);
            $submission->verdict = $verdict;
            $submission->setGradeContent("verdict", $verdict);
            $submission->setGradeContent("output", $output);
            $submission->setGradeContent("total_testcase", $total_testcase);
            $submission->setGradeContent("right_testcase", $right_testcase);
            //$submission->score = ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100);
            $submission->score = $batchScore;
        } else {
            //$submission->setGradeContent("official_result", ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100));
            $submission->setGradeContent("official_result", $batchScore);
            $submission->setGradeContent("official_output", $output);
        }

        if (file_exists($execpath) && !defined("EVALUATOR_DEBUG"))
            unlink($execpath);
    }

}
