<?php

Yii::import("ext.evaluator.base.StandardProblemViewWidgetBase");

class Batchioi2010ProblemViewWidget extends StandardProblemViewWidgetBase {

    public function run(){
        $assetpath = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'assets';
        $assets = Yii::app()->getAssetManager()->publish($assetpath, false, -1, true);
        $cs = Yii::app()->getClientScript()->registerScriptFile($assets.'/style.css');
        $action = isset($_GET['action']) ? $_GET['action'] : '' ;
        switch($action){
            case 'enlarge':
                $this->renderEnlarged();
                break;
            case 'renderviewfile' :
                $this->renderViewFile();
                break;
            case 'submit';
                $this->submitAnswer();
                break;
            default:
                break;
        }
        
        Yii::import('ext.contest.types.ioi2010.Ioi2010Rules');
        $avTokens = Ioi2010Rules::getAvailableTokens($this->contest , $this->submitter , $this->problem);
        //echo $avTokens . "<br />";
        $this->render('problemview', array(
            'problem' => $this->problem,
            'assets' => $assets,
            'submission' => $this->submission,
            'action' => $action,
            'avTokens' => $avTokens
        ));
    }
}