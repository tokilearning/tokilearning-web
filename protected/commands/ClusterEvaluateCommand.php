<?php

Yii::import("application.commands.ClusterCommand");
class ClusterEvaluateCommand extends ClusterCommand {
	const TYPE_CONTEST = "CONTEST";
	const TYPE_CHAPTER = "CHAPTER";

    private static $instance;
    private $submission;
    private $problem;
    private $problemtype;
    private $skipped;
    private static $supportedTypes = array('batchioi2010');

    public static function instance() {
        return self::$instance;
    }
    
    public function requestAdditionalInfo($type) {
    	if ($type == self::TYPE_CONTEST) {
    	}
    	else {
    		
    	}   
    }

    private function getIndex() {
        curl_setopt($this->curlChannel , CURLOPT_URL , "http://".$this->baseUrl."/supervisor/cluster/index");
        $content = curl_exec($this->curlChannel);
        echo $content;
    }

    private function retrieveSubmissionInfo() {
        $ch = $this->curlChannel;
        curl_setopt($ch , CURLOPT_URL , "http://".$this->baseUrl."/supervisor/cluster/getlastpendingsubmission?key=itbitbitb");

        $content = curl_exec($ch);

        if ($content == '0') {
            return false;
        }

        echo $content;

        $obj = json_decode($content , true);
        $s = $obj['submission'];
        $p = $obj['problem'];
        $pt = $obj['problemtype'];

        $this->submission = new Submission();
        $this->submission->setAttributes($s , false);

        $this->problem = new Problem();
        $this->problem->setAttributes($p , false);

        $this->problemtype = new ProblemType();
        $this->problemtype->setAttributes($pt , false);

        return true;
    }

    private function sendReport($postdata) {
        $ch = $this->curlChannel;
        curl_setopt($ch , CURLOPT_URL , "http://".$this->baseUrl."/supervisor/cluster/updatesubmission/id/" . $this->submission->id . "?key=itbitbitb");
        curl_setopt($ch, CURLOPT_POST      ,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS    ,$postdata); 
        $content = curl_exec($ch);
    }
    
    private function cancelGrading() {
        $ch = $this->curlChannel;
        curl_setopt($ch , CURLOPT_URL , "http://".$this->baseUrl."/supervisor/cluster/cancelgrading/id/" . $this->submission->id . "?key=itbitbitb");
        $content = curl_exec($ch);
    }

    public function run($args) {
        self::$instance = $this;
        $this->baseUrl = $args[0];
        $this->username = $args[1];
        $this->password = $args[2];
    
        echo "Attempting to log on to ".$this->baseUrl."..... \n";
        if($this->login($this->username , ")*!@MArx210590")) {
            echo "Login success\n\n";
            
            echo sprintf("Evaluator started\n");
            for (;;) {
                if ($this->retrieveSubmissionInfo()) {
                    echo "Retrieving submission #" . $this->submission->id . "\n";

                    $this->submission->afterFind();
                    $this->problem->afterFind();
                    if ($this->problem->isProblemDirectoryExists() && in_array($this->problemtype->name , self::$supportedTypes)) {
                        Dispatcher::dispatchCluster($this->submission, $this->problem, $this->problemtype);
                        $this->sendReport($this->submission->getAttributes());
                    }
                    else {
                        $this->cancelGrading();
                        echo "GRADING CANCELED \n";
                    }
                }
                else
                    echo "NO SUBMISSION\n";

                sleep(10);
            }
        }
        else
            echo "Login failed\n";
    }

}