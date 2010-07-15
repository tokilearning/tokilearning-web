<?php

Yii::import("ext.evaluator.types.batchioi2010.Batchioi2010Evaluator");

class Reactive1Evaluator extends Batchioi2010Evaluator {

	private $runStatus = 0, $runOutput = array();

	protected function run($testcase) {
		//print_r($testcase);
		$this->inputpath = $this->problem->getFile('evaluator/files/' . $testcase['input']);
		$this->tmpoutput = Sandbox::getTempName();

		$runpath = str_replace('[PROBLEM_PATH]', $this->problem->getFile('evaluator/'), $this->problem->getConfig('command_line'));
		$runpath = str_replace('[SOLUTION]', $this->execpath, $runpath);
		$runpath = str_replace('[TESTCASE]', $this->inputpath, $runpath);

		$wallTimeLimit = $this->timeLimit * 3;
		$sandboxparam = Yii::app()->params->config['evaluator']['sandbox']['moevalbox_path'] . " -e -f -a 2 -t $this->timeLimit -w $wallTimeLimit -m $this->memoryLimit -- " . $this->execpath;
		$wrapperPath = Yii::app()->params->config['evaluator']['sandbox']['moeval_iwrapper_path'] . " " . $runpath . " @@ " . $sandboxparam;

		$this->runOutput = array();
		//echo $wrapperPath . "\n";
		exec($wrapperPath, $this->runOutput, $this->runStatus);
	}

	protected function evaluateOutput(&$score) {
		$retval = true;
		if ($this->runStatus != 0) {
			$err = $this->runOutput[0];
			throw new SandboxException(0, $err);
		} else if ($this->runOutput[1] == '[OK]') {
			$retval = true;
			$score = isset($this->runOutput[2]) ? $this->runOutput[2] / 100 : 1;
		} else if ($this->runOutput[1] == '[FAILED]') {
			$retval = false;
			$score = 0;
		}

		return $retval;
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

		///Compiles checker

		$sourceFile = $problem->getFile('evaluator/files/' . $problem->getConfig('checker_source'));
		$graderFile = $problem->getFile('evaluator/') . '/grader';

		if ($problem->getConfig('checker_source') != "" && file_exists($sourceFile) && (file_exists($graderFile) && filemtime($sourceFile) > filemtime($graderFile) || !file_exists($graderFile))) {
			$checkerSource = $sourceFile;
			$checkerOutput = $graderFile;

			//echo "g++ -o " .$checkerOutput . " " . $checkerSource . "\n";
			exec("g++ -o " . $checkerOutput . " " . $checkerSource . " -lpthread");
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
			if (!defined("EVALUATOR_DEBUG"))
				unlink($source_path);
			return;
		}
		if (!defined("EVALUATOR_DEBUG"))
			unlink($source_path);

		//Execute samples
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
			if (!isset($testcase['sample']))
				continue;

			$batch = (!isset($testcase['batch']) || $testcase['batch'] == '') ? 'default' : $testcase['batch'];
			if (!isset($batchValue[$batch]))
				$batchValue[$batch] = array('total' => 0, 'score' => 0, 'value' => true);
			$batchValue[$batch]['total']++;

			$total_testcase++;
			$output .= "Testcase #" . $i . " (" . $testcase['input'] . ") Subtask " . $batch . "\n";
			$i++;
			$inputpath = $problem->getFile('evaluator/files/' . $testcase['input']);

			$batchPoints = $problem->getConfig('batchpoints');
			if (!$batchValue[$batch]['value'] || $batchPoints[$batch] == 0) {
				$output .= "\tTestcase skipped\n";
				continue;
			}

			//$outputpath = $problem->getFile('evaluator/files/'.$testcase['output']);
			//$tmpoutput = Sandbox::getTempName();
			//$sandboxparam = "-e -f -a 2 -w $time_limit -m $memory_limit -i $inputpath -o $tmpoutput";
			//$execoutput = "";
			//RUN


			$runpath = str_replace('[PROBLEM_PATH]', $problem->getFile('evaluator/'), $problem->getConfig('command_line'));
			$runpath = str_replace('[SOLUTION]', $execpath, $runpath);
			$runpath = str_replace('[TESTCASE]', $inputpath, $runpath);

			//echo $runpath . "\n";

			$sandboxparam = Yii::app()->params->config['evaluator']['sandbox']['moevalbox_path'] . " -e -f -a 2 -t $time_limit -m $memory_limit -- " . $execpath;
			$wrapperPath = Yii::app()->params->config['evaluator']['sandbox']['moeval_iwrapper_path'] . " " . $runpath . " @@ " . $sandboxparam;

			//echo $wrapperPath . "\n";
			$runOutput = array();
			$result = exec($wrapperPath, $runOutput, $status);

			print_r($runOutput);

			if ($status != 0) {
				$isruntimeok = false;
				$err = $runOutput[0];
				$batchValue[$batch]['value'] = false;
				$output .= "FAILED " . $runOutput[0];
			} else if ($runOutput[1] == '[OK]') {
				$right_testcase++;
				$output .= "\tSuccess\n";
			} else if ($runOutput[1] == '[FAILED]') {
				$rightoutput = false;
				$batchValue[$batch]['value'] = false;
				$output .= "\tFAILED " . $runOutput[2] . "\n";
			}

			$output .= "\t" . $runOutput[0] . "\n";


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

		//Execute offical TC
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
			if (isset($testcase['sample']))
				continue;

			$batch = (!isset($testcase['batch']) || $testcase['batch'] == '') ? 'default' : $testcase['batch'];
			if (!isset($batchValue[$batch]))
				$batchValue[$batch] = array('total' => 0, 'score' => 0, 'value' => true);
			$batchValue[$batch]['total']++;

			$total_testcase++;
			$output .= "Testcase #" . $i . " (" . $testcase['input'] . ") Subtask " . $batch . "\n";
			$i++;
			$inputpath = $problem->getFile('evaluator/files/' . $testcase['input']);

			$batchPoints = $problem->getConfig('batchpoints');
			if (!$batchValue[$batch]['value'] || $batchPoints[$batch] == 0) {
				$output .= "\tTestcase skipped\n";
				continue;
			}

			//$outputpath = $problem->getFile('evaluator/files/'.$testcase['output']);
			//$tmpoutput = Sandbox::getTempName();
			//$sandboxparam = "-e -f -a 2 -w $time_limit -m $memory_limit -i $inputpath -o $tmpoutput";
			//$execoutput = "";
			//RUN

			$runpath = str_replace('[PROBLEM_PATH]', $problem->getFile('evaluator/'), $problem->getConfig('command_line'));
			$runpath = str_replace('[SOLUTION]', $execpath, $runpath);
			$runpath = str_replace('[TESTCASE]', $inputpath, $runpath);

			//echo $runpath . "\n";

			$sandboxparam = Yii::app()->params->config['evaluator']['sandbox']['moevalbox_path'] . " -e -f -a 2 -t $time_limit -m $memory_limit -- " . $execpath;
			$wrapperPath = Yii::app()->params->config['evaluator']['sandbox']['moeval_iwrapper_path'] . " " . $runpath . " @@ " . $sandboxparam;

			//echo $wrapperPath . "\n";
			$runOutput = array();
			$result = exec($wrapperPath, $runOutput, $status);

			//print_r($runOutput);

			if ($status != 0) {
				$isruntimeok = false;
				$err = $runOutput[0];
				$batchValue[$batch]['value'] = false;
				$output .= "FAILED " . $runOutput[0];
			} else if ($runOutput[1] == '[OK]') {
				$right_testcase++;
				$output .= "\tSuccess\n";
			} else if ($runOutput[1] == '[FAILED]') {
				$rightoutput = false;
				$batchValue[$batch]['value'] = false;
				$output .= "\tFAILED " . $runOutput[2] . "\n";
			}

			$output .= "\t" . $runOutput[0] . "\n";


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

		if (!$isSampleOnly && false) {
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
