<?php

$problem = $submission->problem;
$time_limit = $problem->getConfig('time_limit') / 1000;
$memory_limit = $problem->getConfig('memory_limit');
$testcases = $problem->getConfig('testcases');

//Compile
$source_content = $submission->getSubmitContent('source_content');
$source_lang = $submission->getSubmitContent('source_lang');
$source_path = Sandbox::getTempName();
file_put_contents($source_path, $source_content);

try {
    $execpath = Compiler::compile($source_path, $source_lang);
} catch (CompilerException $ex) {
    $submission->setGradeContent("verdict", "Compile Error");
    return;
}
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
foreach($testcases as $testcase)
{
	$total_testcase++;
    $output .= "Testcase #".$i."\n";$i++;
    $inputpath = $problem->getEvaluatorFile($testcase['input']);
    $outputpath = $problem->getEvaluatorFile($testcase['output']);
    $tmpoutput = Sandbox::getTempName();
    $sandboxparam = "-e -f -a 2 -w $time_limit -m $memory_limit -i $inputpath -o $tmpoutput";
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
	if (file_exists($tmpoutput)) unlink($tmpoutput);
}
$verdict = ($isruntimeok) ? (($rightoutput) ? "Accepted" : "Wrong Answer") : ($err);
$submission->setGradeContent("verdict", $verdict);
$submission->setGradeContent("output", $output);
$submission->setGradeContent("total_testcase", $total_testcase);
$submission->setGradeContent("right_testcase", $right_testcase);
if (file_exists($execpath)) unlink($execpath);