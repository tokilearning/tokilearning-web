<?php

Yii::import("ext.evaluator.base.EvaluatorBase");

class ArchiveEvaluator extends EvaluatorBase {
    
    public function doEvaluate() {
        self::evaluate($this->submission);
    }

    public static function evaluate($submission) {
        //define("EVALUATOR_DEBUG", true);
        $problem = $submission->problem;
        $time_limit = $problem->getConfig('time_limit') / 1000;
        $memory_limit = $problem->getConfig('memory_limit') / 1024;
        $testcases = $problem->getConfig('testcases');

        ///Checking problem confidentiality
        if ($submission->contest !== null) {
            $cids = explode(" ", $problem->getConfig('sample_contest'));
            //$isSampleOnly = in_array($submission->contest_id, $cids) && $submission->contest_id !== NULL;
            $isSampleOnly = ($submission->contest->contesttype->name == "ioi2010") && ($submission->contest->getConfig('secret'));
        }
        else
            $isSampleOnly = false;

        $sourceFile = $problem->getFile('evaluator/files/' . $problem->getConfig('checker_name'));
        $graderFile = $problem->getFile('evaluator/') . '/grader';

        if ($problem->getConfig('checker_name') != "" && file_exists($sourceFile) && (file_exists($graderFile) && filemtime($sourceFile) > filemtime($graderFile) || !file_exists($graderFile))) {
            $checkerSource = $sourceFile;
            $checkerOutput = $graderFile;

            echo "g++ -o " . $checkerOutput . " " . $checkerSource . "\n";
            exec("g++ -o " . $checkerOutput . " " . $checkerSource);
        }

        //extract
        $zipfile = "/tmp/$submission->submitter_id-$submission->id" . ".zip";
        $extractdir = "/tmp/$submission->submitter_id-$submission->id";
        $handle = fopen($zipfile, "w");
        fclose($handle);
        file_put_contents($zipfile, $submission->file);

        $ar = new ZipArchive;
        if ($ar->open($zipfile)) {
            if ($ar->extractTo($extractdir)) {

                //SAMPLE
                $rightoutput = true;
                $i = 1;
                $total_testcase = 0;
                $right_testcase = 0;
                $output = "";
                $batchValue = array();
                foreach ($testcases as $testcase) {
                    if (!isset($testcase['sample']))
                        continue;

                    $batch = (!isset($testcase['batch']) || $testcase['batch'] == '') ? 'default' : $testcase['batch'];
                    if (!isset($batchValue[$batch]))
                        $batchValue[$batch] = array('total' => 0, 'score' => 0, 'value' => true);
                    $batchValue[$batch]['total']++;

                    $output .= "Testcase #" . $i . "\tBatch " . $batch . "\n\tin : " . $testcase['input'] . " out: " . $testcase['output'] . "\n";
                    $i++;
                    $total_testcase++;
                    $inputpath = $problem->getFile('evaluator/files/' . $testcase['input']);
                    $outputpath = $problem->getFile('evaluator/files/' . $testcase['output']);
                    $tmpoutput = $extractdir . "/" . $testcase['output'];

                    //echo $inputpath . " " . $outputpath . "\n";

                    $tc_score = 0;
                    if ($problem->getConfig('command_line') == '') {
                        $retval = Comparator::compare_file($tmpoutput, $outputpath);
                        $tc_score = 1;
                    } else {
                        $runpath = str_replace('[PROBLEM_PATH]', $problem->getFile('evaluator/'), $problem->getConfig('command_line'));
                        $runpath = str_replace('[OUTPUT]', $tmpoutput, $runpath);
                        $runpath = str_replace('[INPUT]', $inputpath, $runpath);
                        $runpath = str_replace('[OUTPUT_KEY]', $outputpath, $runpath);
                        $runpath = str_replace('[EXTRACT_PATH]', $extractdir, $runpath);

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
                        $rightoutput = $rightoutput && TRUE;
                        $batchValue[$batch]['score'] += $tc_score;
                    } else {
                        $output .= "\tWrong Answer [Score : 0]\n";
                        $rightoutput = $rightoutput && FALSE;
                        $batchValue[$batch]['value'] = false;
                    }
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

                $verdict = (($rightoutput) ? "Accepted" : "Wrong Answer");
                $submission->verdict = $verdict;
                $submission->setGradeContent("verdict", $verdict);
                $submission->setGradeContent("output", $output);
                $submission->setGradeContent("total_testcase", $total_testcase);
                $submission->setGradeContent("right_testcase", $right_testcase);
                //$submission->score = ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100);
                $submission->score = $batchScore;

                ///OFFICIAL
                $rightoutput = true;
                $i = 1;
                $total_testcase = 0;
                $right_testcase = 0;
                $output = "";
                $batchValue = array();
                foreach ($testcases as $testcase) {
                    if (isset($testcase['sample']))
                        continue;

                    $batch = (!isset($testcase['batch']) || $testcase['batch'] == '') ? 'default' : $testcase['batch'];
                    if (!isset($batchValue[$batch]))
                        $batchValue[$batch] = array('total' => 0, 'score' => 0, 'value' => true);
                    $batchValue[$batch]['total']++;

                    $output .= "Testcase #" . $i . "\tBatch " . $batch . "\n\tin : " . $testcase['input'] . " out: " . $testcase['output'] . "\n";
                    $i++;
                    $total_testcase++;
                    $inputpath = $problem->getFile('evaluator/files/' . $testcase['input']);
                    $outputpath = $problem->getFile('evaluator/files/' . $testcase['output']);
                    $tmpoutput = $extractdir . "/" . $testcase['output'];

                    //echo $inputpath . " " . $outputpath . "\n";

                    $tc_score = 0;
                    if ($problem->getConfig('command_line') == '') {
                        $retval = Comparator::compare_file($tmpoutput, $outputpath);
                        $tc_score = 1;
                    } else {
                        $runpath = str_replace('[PROBLEM_PATH]', $problem->getFile('evaluator/'), $problem->getConfig('command_line'));
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

                if (!$isSampleOnly && false) {
                    $verdict = ($rightoutput) ? "Accepted" : "Wrong Answer";
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
            }
        }


        unlink($zipfile);
        exec("rm -rf $extractdir");
    }

}
