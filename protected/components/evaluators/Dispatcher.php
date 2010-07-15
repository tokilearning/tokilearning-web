<?php

class Dispatcher{

    public static function dispatch($submission){
        echo self::renderStat($submission);
        Yii::import('ext.evaluator.SubmissionEvaluator');
        try {
            $evaluator = SubmissionEvaluator::getEvaluator($submission);
            $evaluator->evaluate($submission);
            //include $evaluator_script;
            $submission->setGradeStatus(Submission::GRADE_STATUS_GRADED);
            $submission->save();
            if ($submission->chapter_id != NULL) {
                /*$isCompleted = $submission->chapter->isCompleted($submission->submitter , false);
                $submission->chapter->getRootChapter()->isCompleted($submission->submitter , false , false);*/
                $submission->chapter->updateUser($submission->submitter);
            }
        } catch (Exception $ex){
            echo sprintf("%s : %s\n".
                    "\t%s at %s\n".
                    "\t%s\n"
                        , get_class($ex), $ex->getMessage(),
                        $ex->getFile(), $ex->getLine(),
                        str_replace("\n", "\n\t", $ex->getTraceAsString())
                    );
            $submission->setGradeStatus(Submission::GRADE_STATUS_ERROR);
            $submission->save();
        }
    }

    public static function dispatchCluster($submission , $problem , $problemtype) {
        Yii::import('ext.evaluator.SubmissionEvaluator');
        try {
            $evaluator = SubmissionEvaluator::getClusterEvaluator($problemtype->name);
            $evaluator->evaluateCluster($submission , $problem , $problemtype);
            $submission->setGradeStatus(Submission::GRADE_STATUS_GRADED);
            $submission->beforeSave();
        } catch (Exception $ex) {
            echo sprintf("%s : %s\n".
                    "\t%s at %s\n".
                    "\t%s\n"
                        , get_class($ex), $ex->getMessage(),
                        $ex->getFile(), $ex->getLine(),
                        str_replace("\n", "\n\t", $ex->getTraceAsString())
                    );
            $submission->setGradeStatus(Submission::GRADE_STATUS_ERROR);
        }
    }

    private static function renderStat($submission){
        return sprintf("Dispatching :\n" .
                     "\tSubmission   #%d\n" .
                     "\tProblem      #%d\n" .
                     "\tProblem Type #%s\n" ,
                     $submission->id,
                     $submission->problem->id,
                     $submission->problem->problemtype->name
                    );
    }

//    public static function dispatch($submission){
//        echo self::renderStat($submission);
//        $evaluator_script = $submission->problem->problemtype->getEvaluatorScriptPath();
//        try {
//            //include $evaluator_script;
//            //$submission->setGradeStatus(Submission::GRADE_STATUS_GRADED);
//            //$submission->save();
//        } catch (Exception $ex){
//            echo sprintf("%s : %s\n".
//                    "\t%s at %s\n".
//                    "\t%s\n"
//                    , get_class($ex), $ex->getMessage(),
//                    $ex->getFile(), $ex->getLine(),
//                    str_replace("\n", "\n\t", $ex->getTraceAsString())
//                    );
//            //$submission->setGradeStatus(Submission::GRADE_STATUS_ERROR);
//            //$submission->save();
//        }
//    }
}
