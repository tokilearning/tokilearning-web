<?php

class ProblemStatWidget extends CWidget {
    public $handler;

    private function generateDetail($pSubmissions) {
	///TODO: pass to problem type
	echo "#,username,nama\n";

	foreach ($pSubmissions as $submission) {
	    echo '"' . $submission->submitter->id . '"' . "," . $submission->submitter->username . ',"' . $submission->submitter->full_name . '",';

	    if ($submission->getSubmitContent('answers') !== NULL) {
		foreach ($submission->getSubmitContent('answers') as $key => $answer) {
		    echo '"' . $answer . '",';
		}
		echo "\n";
	    }
	}

	/**
	$rankedSubmissions = $this->handler->getRankedSubmissions($this->handler->getContest() , true);

	$tRankedSubmissions = array();
	foreach ($rankedSubmissions as $submission) {
	    $tRankedSubmissions[$submission->submitter->id][$submission->problem->id] = $submission;
	}

	echo "#,username,nama\n";

	$userSubs = array();
	foreach ($pSubmissions as $submission) {
	    //echo '"' . $submission->submitter->id . '"' . "," . $submission->submitter->username . ',"' . $submission->submitter->full_name . '",';

	    /*if ($submission->getSubmitContent('answers') !== NULL) {
		foreach ($submission->getSubmitContent('answers') as $key => $answer) {
		    echo '"' . $answer . '",';
		}
		echo "\n";
	    }
	    $userSubs[$submission->submitter->id][] = $submission;
	}

	foreach ($userSubs as $userId => $userSub) {
	    $user = User::model()->findByPK($userId);
	    echo '"' . $user->id . '"' . "," . $user->username . ',"' . $user->full_name . '",';

	    echo $tRankedSubmissions[$user->id][$pSubmissions[0]->problem->id]->getGradeContent('official_result') . ",";

	    foreach ($userSub as $sub) {
		echo $sub->getGradeContent('official_result');

		if ($sub->getSubmitContent('fullfeedback'))
		    echo " (T)";
		echo ",";
	    }

	    echo "\n";
	}
	**/
    }

    private function generateStat($pSubmissions) {
	///TODO: pass to problem type
	$stats = array();
	foreach ($pSubmissions as $submission) {
	    if ($submission->getSubmitContent('answers') !== NULL) {
		foreach ($submission->getSubmitContent('answers') as $key => $answer) {
		    if (!isset($stats[$key + 1]))
			$stats[$key + 1] = array();

		    if (!isset($stats[$key + 1][$answer]))
			$stats[$key + 1][$answer] = 0;

		    $stats[$key + 1][$answer]++;
		}
	    }
	}
	echo "#,Jawaban,Jumlah\n";

	foreach ($stats as $key => $answers) {
	    $i = 0;
	    foreach ($answers as $answer => $count) {
		if ($i == 0)
		    echo $key . ",";
		else
		    echo "\"\",";

		echo $answer . "," . $count . "\n";

		$i++;
	    }
	}
    }

    public function run() {
	$contest = $this->handler->getContest();

	if (isset($_GET['action']) && $_GET['action'] === "download" && isset($_GET['problemid'])) {
	    $submissions = Submission::model()->findAll(array(
		'condition' => "contest_id = $contest->id AND problem_id = " . $_GET['problemid']
	    ));

	    ob_clean();
	    header('Content-type: text/csv');
	    header('Content-Disposition: attachment; filename="stat-' . Problem::model()->findByPK($_GET['problemid'])->title . '.csv"');
	    $this->generateStat($submissions);
	    exit;
	}
	else if (isset($_GET['action']) && $_GET['action'] === "downloadDetail" && isset($_GET['problemid'])) {
	    $submissions = Submission::model()->findAll(array(
		'condition' => "contest_id = $contest->id AND problem_id = " . $_GET['problemid']
	    ));

	    ob_clean();
	    header('Content-type: text/csv');
	    header('Content-Disposition: attachment; filename="detail-' . Problem::model()->findByPK($_GET['problemid'])->title . '.csv"');
	    $this->generateDetail($submissions);
	    exit;
	}

	$textProblems = array();
	///TODO: ignore this filter to simpletext
	foreach ($contest->problems as $problem) {
	    $problemType = ProblemType::model()->findByPK($problem->problem_type_id);

	    if ($problemType !== null && $problemType->name === "simpletext") {
		$textProblems[] = $problem;
	    }
	}

	$dataProvider = new CArrayDataProvider($textProblems , array(
	    'pagination'=>array(
                'pageSize'=>20,
            )
	));

	$this->render('problemstat' , array('dataProvider' => $dataProvider));
    }
}
