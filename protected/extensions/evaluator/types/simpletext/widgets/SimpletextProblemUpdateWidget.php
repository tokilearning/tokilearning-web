<?php

Yii::import("ext.evaluator.base.StandardProblemUpdateWidgetBase");

class SimpletextProblemUpdateWidget extends StandardProblemUpdateWidgetBase {

    public function run() {
        $assetpath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager()->publish($assetpath, false, -1, true);
        Yii::app()->getClientScript()->registerCssFile($assets . '/style.css');
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        switch ($action) {
            case 'files' :
                $this->updateFiles();
            case 'problems':
                $this->updateProblems();
                break;
            case 'renderviewfile' :
                $this->renderViewFile();
                break;
        }
        $this->render('problemupdate', array(
            'problem' => $this->problem,
            'action' => $action,
            'assets' => $assets
        ));
    }

    public function updateProblems() {
        if (isset($_POST['config'])) {
            $config = $_POST['config'];
            $problems = array();
            if (isset($config['problems'])) {
                $i = 0;
                foreach ($config['problems'] as $p) {
                    $p['answer'] = urldecode($p['answer']);
                    $p['question'] = urldecode($p['question']);

                    foreach ($p['alternatives'] as $key => $alt) {
                        $p['alternatives'][$key]['answer'] = urldecode($alt['answer']);
                    }

                    $p['id'] = $i++;
                    $problems[] = $p;
                }
            }
            $this->problem->setConfig('problems', $problems);
            $this->problem->save();
        }
    }

}