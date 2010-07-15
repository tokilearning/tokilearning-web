<?php

class GraderController extends CAdminController {

    private function isGraderRunning() {
        $pidFile = Yii::app()->params->config['evaluator']['balancer']['pid-file'];

        if (file_exists($pidFile)) {
            $pid = file_get_contents($pidFile);
            $pid = str_replace("\n" , "" , $pid);
            $procPath = "/proc/" . $pid;
        }

        return file_exists($procPath);
    }

    public function actionIndex() {
        /////Find phantoms
        $phantoms = Submission::getPhantomSubmissions();

        if (isset($_GET['clearphantoms']) && count($phantoms) > 0) {
            $msgKey = Yii::app()->params->config['evaluator']['balancer']['message-key'];
            $msgType = Yii::app()->params->config['evaluator']['balancer']['message-type'];

            foreach ($phantoms as $submission) {
                exec("sender " . $submission->id . " " . $msgKey . " " . $msgType);
            }
        }

        $phantoms = Submission::getPhantomSubmissions();

        $this->render('index' , array(
            'pid' => $pid ,
            'running' => $this->isGraderRunning(),
            'phantoms' => $phantoms
        ));
    }

    public function actionStartEngine() {
        if (!$this->isGraderRunning()) {
            exec("starter " . Yii::app()->params->config['evaluator']['balancer']['config-file'] . " " . Yii::app()->params->config['evaluator']['balancer']['app-id']);
            echo "0";
        }
    }
}

