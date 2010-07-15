<?php

Yii::import("application.commands.ClusterCommand");
class ClusterSyncCommand extends ClusterCommand {
    private static $instance;
    private $problems = array();
    private $downloadedProblems = array();
    private $localProblems = array();

    public static function instance() {
        return self::$instance;
    }

    private function getProblems() {
        curl_setopt ($this->curlChannel, CURLOPT_URL, $this->createUrl('supervisor/cluster/getproblems?key=itbitbitb'));
        $content = curl_exec($this->curlChannel);
        echo "RESP : " . $content . "\n";
        $this->problems = json_decode($content);
    }

    private function synchronizeProblems() {
        //print_r($this->localProblems);

        $this->downloadedProblems = array();
        //$localProblems = Problem::model()->findAll();
        $localProblems = $this->localProblems;

        $localTokens = array();
        foreach ($localProblems as $key => $problem) {
            $localTokens[$key] = $problem;
        }

        foreach ($this->problems as $key => $problem) {
            if (!in_array($problem , $localTokens)) {
                $this->downloadedProblems[$key] = $problem;
            }
        }

        //print_r($this->downloadedProblems);
    }

    private function downloadProblems() {
        foreach ($this->downloadedProblems as $id => $problem) {
            $this->downloadProblem($id , Yii::app()->params->config['evaluator']['problem']['problem_repository_path'] . '/' . $problem . ".zip");
        }

        if (count($this->downloadedProblems) != 0)
            $this->localProblems = $this->downloadedProblems;
    }

    public function run($args) {
        self::$instance = $this;
        $this->baseUrl = $args[0];
        $this->username = $args[1];
        $this->password = $args[2];

        echo "Attempting to log on to ".$this->baseUrl."..... \n";
        if($this->login('karol' , ')*!@MArx210590')) {
                echo "Login success\n\n";

            echo sprintf("Synchronizing\n");
            for(;;) {
                $this->problems = array();
                $this->downloadedProblems = array();

                $this->getProblems();
                $this->synchronizeProblems();
                $this->downloadProblems();

                //$this->downloadProblem();
                echo "NO SYNC\n";
                sleep(2);
            }
        }
    }
}

?>