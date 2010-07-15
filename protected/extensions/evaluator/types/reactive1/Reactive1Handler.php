<?php

Yii::import("ext.evaluator.base.StandardHandlerBase");

class Reactive1Handler extends StandardHandlerBase {

    public static function initializeProblem($problem){
        $directory_path = $problem->getDirectoryPath();
        if (!file_exists($directory_path)){
            mkdir($directory_path, 0777);
        }else if (!is_dir($directory_path)){
            ulink($directory_path);
        }
        mkdir($directory_path . 'evaluator/', 0777);
        mkdir($directory_path . 'evaluator/files/', 0777);
        mkdir($directory_path . 'view/', 0777);
        mkdir($directory_path . 'view/files/', 0777);
        //
        copy(dirname(__FILE__).'/data/config.json', $directory_path.'config.json');
        copy(dirname(__FILE__).'/data/description.html', $directory_path.'view/description.html');
    }
    
}