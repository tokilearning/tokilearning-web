<?php

class CSyntaxHighlighter {
    public static function getTypes(){
        $types = array(
            'cpp' => 'C++',
            'c' => 'C',
            'java' => 'Java',
            'pascal' => 'Pascal',
            'pas' => 'Pascal',
            'pp' => 'Pascal',
            'text' => 'Text'
        );
        return $types;
    }

    public static function getScript($type){
        $scripts = array(
            'cpp' => 'shBrushCpp.js',
            'c' => 'shBrushCpp.js',
            'java' => 'shBrushJava.js',
            'pascal' => 'shBrushDelphi.js',
            'pas' => 'shBrushDelphi.js',
            'pp' => 'shBrushDelphi.js',
            'text' => 'shBrushPlain.js'
        );
        return $scripts[$type];
    }
    
    public static function registerFiles($type){
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/syntax/shCore.css");
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/syntax/shThemeDefault.css");
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/scripts/syntax/shCore.js");
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/scripts/syntax/".self::getScript($type));
        Yii::app()->clientScript->registerScript('pastebin-js', '
            SyntaxHighlighter.all();
        ');
    }
}