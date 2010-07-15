<?php
Yii::import("ext.evaluator.types.multiplesource.model.MultiplesourceArchive");

class MultiplesourceEvaluator {

    public static function evaluate($pSubmission) {
        ///Init
        $problem = $pSubmission->problem;

        ///Compiles checker
        $sourceFile = $problem->getFile('evaluator/files/' . $problem->getConfig('checker_source'));
        $graderFile = $problem->getFile('evaluator/') . '/grader';

        /*if ($problem->getConfig('checker_source') != "" && file_exists($sourceFile) && (file_exists($graderFile) && filemtime($sourceFile) > filemtime($graderFile) || !file_exists($graderFile))) {
            $checkerSource = $sourceFile;
            $checkerOutput = $graderFile;

            echo "g++ -o " .$checkerOutput . " " . $checkerSource . "\n";
            exec("g++ -o " .$checkerOutput . " " . $checkerSource);
        }*/

        ///Prepare extract dir
        $zipfile = "/tmp/$pSubmission->submitter_id-$pSubmission->id" . ".zip";
        $extractdir = "/tmp/".time()."-$pSubmission->submitter_id-$pSubmission->id";
        $handle = fopen($zipfile , "w");
        fclose($handle);

        $ar = MultiplesourceArchive::model()->find(array('condition' => 'submission_id = ' . $pSubmission->id));

        file_put_contents($zipfile , $ar->file);

        $ar = new ZipArchive;
        if ($ar->open($zipfile)) {
            if ($ar->extractTo($extractdir)) {
                //echo $sourceFile . " " . $extractdir . "/" . $problem->getConfig('checker_source') . "\n";

                copy($sourceFile, $extractdir . "/" . $problem->getConfig('checker_source'));

                exec("make -f $extractdir/Makefile -C $extractdir 2>&1" , $makeOutput , $result);

                if ($result == 0) { ///Make ok
                    $runcommand = $pSubmission->problem->getConfig('command_line');
                    $runcommand = str_replace("[SOLUTION_PATH]", $extractdir, $runcommand);
                    $runcommand = str_replace("[PROBLEM_PATH]", $problem->getFile('evaluator/files/'), $runcommand);

                    $failed = false;
                    try {
                        $result = Sandbox::plainExecute("/bin/mo-evalbox -a 2 -e -- " . $runcommand . " 2>&1", $sandboxOutput);
                    }
                    catch (Exception $ex) {
                        $failed = true;
                        $pSubmission->setGradeContent('output' , $ex->getMessage());
                    }
                    $sRunOutput = $sandboxOutput;
                    
                    if (!$failed) {
                        $pSubmission->verdict = "Accepted";
                        $pSubmission->setGradeContent('output' , $sRunOutput);
                    }
                    else {
                        $pSubmission->verdict = "Runtime Error";
                    }
                }
                else { ///Make failed
                    $pSubmission->setGradeContent('output' , implode("\n" , $makeOutput));
                    $pSubmission->verdict = "Compile Error";
                }

                exec("rm -rf $extractdir");
            }
        }

        unlink($zipfile);
    }
}

?>
