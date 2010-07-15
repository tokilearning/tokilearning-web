<?php

Yii::import("ext.evaluator.base.EvaluatorBase");

class BatchacmEvaluator extends EvaluatorBase {
    
    public function doEvaluate() {
        self::evaluate($this->submission);
    }

    private static function toUnixTimeStamp($time) {
        list($date , $time) = explode(' ' , $time);
        list($Y,$M,$D) = explode('-' , $date);
        list($h,$m,$s) = explode(':' , $time);

        return mktime($h , $m , $s , $M , $D , $Y);
    }

    public static function evaluate($submission){
        //define("EVALUATOR_DEBUG", true);
        $problem = $submission->problem;
        $time_limit = $problem->getConfig('time_limit') / 1000;
        $memory_limit = $problem->getConfig('memory_limit') / 1024;
        $testcases = $problem->getConfig('testcases');

        $contest_id = $submission->contest_id;
        $problem_id = $submission->problem_id;
        $submitter_id = $submission->submitter_id;

        $subs = array();
        $initScore = 0;

        if ($contest_id != "") {
            $subs = Submission::model()->findAll(array(
                'condition' => "score = 0 AND id < $submission->id AND submitter_id = $submitter_id AND problem_id = $problem_id AND contest_id = $contest_id"
            ));

            $submitted_time = BatchacmEvaluator::toUnixTimeStamp($submission->submitted_time);
            $contest = Contest::model()->findByPk($contest_id);
            $contest_end_time = BatchacmEvaluator::toUnixTimeStamp($contest->end_time);

            $initScore += intval(($contest_end_time - $submitted_time) / 60);

            $previous_subs = count($subs);

            $initScore -= $previous_subs * 20;
            
        }

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
            $total_testcase++;
            $output .= "Testcase #".$i."\n";$i++;
            $inputpath = $problem->getFile('evaluator/files/'.$testcase['input']);
            $outputpath = $problem->getFile('evaluator/files/'.$testcase['output']);
            $tmpoutput = Sandbox::getTempName();
            $sandboxparam = "-e -f -a 2 -t $time_limit -m $memory_limit -i $inputpath -o $tmpoutput";
            $execoutput = "";
            try {
            Sandbox::execute($sandboxparam, $execpath, $execoutput);
                    if (strlen($execoutput) > 0) {
                            $output .= "\t".str_replace("\n", "\n\t", $execoutput)."\n";
                    }
                    $retval = Comparator::compare_file($tmpoutput, $outputpath);
                    if ($retval){
                            $output .= "\tAccepted\n";
                            $right_testcase++;
                            $rightoutput = $rightoutput && TRUE;
                    } else {
                            $output .= "\tWrong Answer\n";
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

        if ($right_testcase != $total_testcase)
            $submission->score = 0;
        else
            $submission->score = 100 + $initScore;
        
        if (file_exists($execpath) && !defined("EVALUATOR_DEBUG")) unlink($execpath);

    }
    
}
