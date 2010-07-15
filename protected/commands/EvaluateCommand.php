<?php

Yii::import('ext.evaluator.SubmissionEvaluator');


class EvaluateCommand extends CConsoleCommand {

    private $mResource;
    private $mMsgKey;
    private $mMsgType;
    private $mGraderUrl = "http://167.205.32.27/lx";

    public function run($args) {
        if (count($args) > 0) {
            if ($args[0] == "cleanup") {
                $this->cleanupPendingSubmissions();
            }
            else if ($args[0] == "queue") {
                $this->processQueue($args[1] , $args[2]);
            }
            else
                $this->singleEvaluate($args[0]);
                
            exit(0);
        }

        echo sprintf("Evaluator started\n");
        for (;;) {
            $submission = Submission::getFirstPending();
            if ($submission == null) {
                echo sprintf("No submission\n");
                sleep(10); //sleep 20 second
                continue;
            } else {
                echo sprintf("Find submission : #%d\n", $submission->id);
                Dispatcher::dispatch($submission);
            }
        }
    }

    private function cleanupPendingSubmissions() {
        $submissions = Submission::model()->findAll("grade_status = " . Submission::GRADE_STATUS_PENDING);
        $msgKey = Yii::app()->params->config['evaluator']['balancer']['message-key'];
        $msgType = Yii::app()->params->config['evaluator']['balancer']['message-type'];

        foreach ($submissions as $submission) {
            exec("sender " . $submission->id . " " . $msgKey . " " . $msgType);
        }
        
        echo "Got " . count($submissions) . " phantoms\n";
    }

    private function evaluateToCluster($pSubmission) {
        $tSubmission = $pSubmission;

        $gradingInfo = array();
        $gradingInfo['language'] = $tSubmission->getSubmitContent('source_lang');
        $gradingInfo['source'] = $tSubmission->getSubmitContent('source_content');

        ///Problem specific
        $gradingInfo['token'] = $tSubmission->problem->token;
        $gradingInfo['time_limit'] = $tSubmission->problem->getConfig('time_limit');
        $gradingInfo['memory_limit'] = $tSubmission->problem->getConfig('memory_limit');
        $gradingInfo['testcases'] = $tSubmission->problem->getConfig('testcases');
        
        ///Optional
        $gradingInfo['checker_source'] = $tSubmission->problem->getConfig('checker_source');
        $gradingInfo['checker_run_command'] = $tSubmission->problem->getConfig('command_line');

        $sGradingInfo = urlencode(json_encode($gradingInfo));

        //echo $sGradingInfo;

        $c = new Channel('http://localhost');

        //echo $c->execute("http://167.205.32.29/lx/cluster/grade" , "POST" , "payload=$sGradingInfo&key=KD");
        $graderResponse = null;
        $response = $c->execute("$this->mGraderUrl/cluster/grade" , "POST" , "payload=$sGradingInfo&key=KD");


        if (!$response) {
            echo "HTTP Connection Failure\n";

            ///Send error code (!= 0) back to dispatcher
            msg_send($this->mResource , $this->mMsgType , "1" , false);
        }
        else if (is_array($graderResponse = json_decode($response , true))) {
            echo "Proper response received, processing grading result\n";

            $evaluator = SubmissionEvaluator::getEvaluator($pSubmission);

            $evaluator->evaluateClusterResult($pSubmission , $graderResponse);

            //print_r($graderResponse);

            $pSubmission->setGradeStatus(Submission::GRADE_STATUS_GRADED);
            $pSubmission->save();
        }
    }

    private function singleEvaluate($pSubmissionId) {
        $tSubmission = Submission::model()->findByPK($pSubmissionId);

        if ($tSubmission->problem->problemtype->name == "batchioi2010") {
            //$this->evaluateToCluster($tSubmission);
            //return;
        }

        if ($tSubmission !== NULL /*&& $tSubmission->grade_status != Submission::GRADE_STATUS_GRADED*/) {
            echo "Grading submission #" . $pSubmissionId . "\n";
            Dispatcher::dispatch($tSubmission);
        }
        else if ($tSubmission->grade_status == Submission::GRADE_STATUS_GRADED) {
            echo "Submission already graded. Aborting...\n";
        }
        else
            echo "Submission not found. Aborting...\n";
    }
    
    private function processQueue($pKey , $msgType) {
        $mqResource = msg_get_queue($pKey , 0666);
        $this->mResource = $mqResource;
        $this->mMsgType = $msgType;
        $this->mMsgKey = $pKey;

        echo "Starting evaluator with key $pKey\n";

        while (true) {
            $result = msg_receive($mqResource , $msgType , $type , 110 , $submissionId , false);

            $realSubId = "";
            for ($i = 0 ; $i < strlen($submissionId) ; $i++) {
                if ($submissionId[$i] >= '0' && $submissionId[$i] <= '9')
                    $realSubId .= $submissionId[$i];
                else break;
            }

            //echo $realSubId . " " . strlen($realSubId) . "\n";
            $submissionId = $realSubId;
            //echo strlen($submissionId) . "\n";

            echo "#$submissionId received\n";
            if ($result) {
                $this->singleEvaluate($submissionId);
                msg_send($mqResource , $msgType , "0" , false);
            }
        }
    }

}
