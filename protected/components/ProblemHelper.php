<?php

class ProblemHelper {

    public static function renderDescription($problem, $tostring = true){
        $contents = file_get_contents($problem->getDescriptionPath());
        if ($tostring){
            return $contents;
        } else {
            echo $contents;
        }
    }

    //---------------------------------------------------------------------------
    public static function updateDescription($problem, $contents){
        return file_put_contents($problem->getDescriptionPath(), $contents);
    }

    public static function renderConfigForm($problem){
        $configFormPath = $problem->problemtype->getViewDirectoryPath()."config.php";
        include $configFormPath;
    }

    public static function updateConfig($problem, $config){
        $controllerFile = $problem->problemtype->getViewDirectoryPath()."controller.php";
        include $controllerFile;
        return call_user_func('config', $problem, $config);
    }

    //---------------------------------------------------------------------------
    public static function submitAnswer($submission){
        $controllerFile = $submission->problem->problemtype->getViewDirectoryPath()."controller.php";
        include $controllerFile;
        return call_user_func('submit', $submission);
    }

    public static function renderSubmitForm($problem, $tostring = FALSE){
        $submitFormPath = $problem->problemtype->getViewDirectoryPath()."submit.php";
        include $submitFormPath;
    }

    public static function renderAnswer($submission, $tostring = FALSE){
        $submission_view_path = $submission->problem->problemtype->getViewDirectoryPath()."submission.php";
        include $submission_view_path;
    }
    //---------------------------------------------------------------------------
}