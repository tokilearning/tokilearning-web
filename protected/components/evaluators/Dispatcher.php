<?php

class Dispatcher{

    public static function dispatch($submission){
        echo self::renderStat($submission);
        $evaluator_script = $submission->problem->problemtype->getEvaluatorScriptPath();
        try {
            include $evaluator_script;
            $submission->setGradeStatus(Submission::GRADE_STATUS_GRADED);
            //$submission->save();
        } catch (Exception $ex){
//            echo sprintf("%s : %s\n".
//                    "\t%s at %s\n".
//                    "\t%s\n"
//                    , get_class($ex), $ex->getMessage(),
//                    $ex->getFile(), $ex->getLine(),
//                    str_replace("\n", "\n\t", $ex->getTraceAsString())
//                    );
            $submission->setGradeStatus(Submission::GRADE_STATUS_ERROR);
            //$submission->save();
        }
    }

    private static function renderStat($submission){
        return sprintf("Dispatching :\n" .
                     "\tSubmission   #%d\n" .
                     "\tProblem      #%d\n" .
                     "\tProblem Type #%s\n" .
                     "\tEvaluator    #%s\n",
                     $submission->id,
                     $submission->problem->id,
                     $submission->problem->problemtype->name,
                     $submission->problem->problemtype->getEvaluatorScriptPath()
                    );
    }
}