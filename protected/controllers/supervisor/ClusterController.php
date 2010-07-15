<?php

class ClusterController extends CSupervisorController {
    private static $key = 'itbitbitb';

    public function actionIndex() {
        echo "OK\n";
    }

    public function actionGetLastPendingSubmission() {
        $submission = Submission::getFirstPending();

        if ($submission !== null && $_GET['key']===self::$key) {
            $retval = array();
            $retval['submission'] = $submission->getAttributes();
            $retval['problem'] = $submission->problem->getAttributes();
            $retval['problemtype'] = $submission->problem->problemtype->getAttributes();
            $submission->setGradeStatus(Submission::GRADE_STATUS_WAITING);
            $submission->save();

            echo json_encode($retval);
        }
        else
            echo "0";
    }
    
    public function actionGetFile($id) {
        $problem = Problem::model()->findByPK($id);
        if ($problem !== null && $_GET['key'] === self::$key) {
            $path = $_GET['path'];
            $content = file_get_contents($problem->getDirectoryPath() . "/" . $path);
            echo $content;
        }
    }
    
    public function actionGetProblems() {
    	if ($_GET['key'] === self::$key) {
            $problems = Problem::model()->findAll();
            $retval = array();
            foreach ($problems as $problem) {
                ///TODO: FILTER MODIFIED DATE
                if ($problem->problemtype->name == "batchioi2010")
                    //$retval[$problem->id] = $problem->token;
                    $retval['problems'][$problem->id] = array(
                        'token' => $problem->token,
                        'checksum' => $problem->generateChecksum(),
                        'modified_date' => $problem->modified_date            
                    );
            }
            $retval['update_time'] = time();
            echo json_encode($retval);
    	}
    }
    
    public function actionGetInitialProblems() {
        if ($_GET['key'] === self::$key) {
            $problems = Problem::model()->findAll();
            $retval = array();
            foreach ($problems as $problem) {
                ///TODO: FILTER MODIFIED DATE
                if ($problem->problemtype->name == "batchioi2010")
                    //$retval[$problem->id] = $problem->token;
                    $retval['problems'][$problem->id] = array(
                        'token' => $problem->token            
                    );
            }
            $retval['update_time'] = time();
            echo json_encode($retval);
    	}
    }

    public function actionGetProblem($id) {
        $problem = Problem::model()->findByPK($id);
        if ($_GET['key'] === self::$key && $problem !== null) {
            $retval = array();
            if ($problem->problemtype->name == "batchioi2010")
                //$retval[$problem->id] = $problem->token;
                $retval = array(
                    'token' => $problem->token,
                    'checksum' => $problem->generateChecksum(),
                    'modified_date' => $problem->modified_date             
                );
            echo json_encode($retval);
    	}
    }
    
    public function actionUpdateSubmission($id) {
        $submission = Submission::model()->findByPK($id);
        if ($submission !== null && $_GET['key'] === self::$key) {
            print_r($_POST);

            $submission->grade_content = $_POST['grade_content'];
            $submission->grade_time = new CDbExpression("NOW()");
            $submission->grade_output = $_POST['grade_output'];
            $submission->grade_status = $_POST['grade_status'];
            $submission->verdict = $_POST['verdict'];
            $submission->score = $_POST['score'];
            $submission->afterFind();

            $submission->save(false);
            
            if ($submission->chapter_id != null) {
				$submission->chapter->updateUser($submission->submitter);            
            }
        }
    }

    public function actionCancelGrading($id) {
        $submission = Submission::model()->findByPK($id);
        if ($submission !== null && $_GET['key'] === self::$key) {
            $submission->setGradeStatus(Submission::GRADE_STATUS_PENDING);
            $submission->save();
        }
    }
    
    public function actionGetContestInformation($id) {
    	$contest = Contest::model()->findByPK($id);
    	if ($contest !== null && $_GET['key'] === self::$key) {
    		echo json_encode($contest->getAttributes());
    	}    	    
    }
    
}
