<?php

Yii::import("ext.evaluator.base.EvaluatorBase");

class SimplebatchEvaluator extends EvaluatorBase {

	public function doEvaluate() {
		self::evaluate($this->submission);
	}

	public static function evaluate($submission) {
		//define("EVALUATOR_DEBUG", true);
		$problem = $submission->problem;
		$time_limit = $problem->getConfig('time_limit') / 1000;
		$memory_limit = $problem->getConfig('memory_limit') / 1024;
		$testcases = $problem->getConfig('testcases');

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
			$submission->verdict = "Compile Error";
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
		foreach ($testcases as $testcase) {
			$total_testcase++;
			$output .= "Testcase #" . $i . "\tin : " . $testcase['input'] . " out: " . $testcase['output'] . "\n";
			$i++;
			$inputpath = $problem->getFile('evaluator/files/' . $testcase['input']);
			$outputpath = $problem->getFile('evaluator/files/' . $testcase['output']);
			$tmpoutput = Sandbox::getTempName();
			$wallTimeLimit = $time_limit * 3;
			$sandboxparam = "-e -f -a 2 -t $time_limit -w $wallTimeLimit -m $memory_limit -i $inputpath -o $tmpoutput";
			$execoutput = "";
			try {
				Sandbox::execute($sandboxparam, $execpath, $execoutput);
				if (strlen($execoutput) > 0) {
					//Kena Hack somehow
					$execoutput = "\t" . str_replace("\n", "\n\t", substr($execoutput, 0, 100)) . "\n";
				}
				$retval = Comparator::compare_file($tmpoutput, $outputpath);
				if ($retval) {
					$output .= $execoutput . "\tAccepted\n";
					$right_testcase++;
					$rightoutput = $rightoutput && TRUE;
				} else {
					$output .= "\tWrong Answer\n";
					$rightoutput = $rightoutput && FALSE;
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
		$verdict = ($isruntimeok) ? (($rightoutput) ? "Accepted" : "Wrong Answer") : ($err);
		$submission->verdict = $verdict;
		$submission->setGradeContent("verdict", $verdict);
		$submission->setGradeContent("output", $output);
		$submission->setGradeContent("total_testcase", $total_testcase);
		$submission->setGradeContent("right_testcase", $right_testcase);
		$submission->score = ($total_testcase == 0) ? 0 : (($right_testcase / $total_testcase) * 100);
		if (file_exists($execpath) && !defined("EVALUATOR_DEBUG"))
			unlink($execpath);
	}

}
