<?php

class IoiRankViewWidget extends CWidget {

    public $contest;
    private $ranks;
    public $supervisor;
    public $fullRank = false;

    public function run() {
        if ($this->supervisor) {
            $action = isset($_GET['action']) ? $_GET['action'] : '';
            $mode = isset($_GET['mode']) ? $_GET['mode'] : '';

            switch ($mode) {
                case 'fullRank':
                    $this->ranks = $this->getRanking(false, false, true);
                    break;
                default:
                    $this->ranks = $this->getRanking(false, false, false);
                    break;
            }

            switch ($action) {
                case 'downloadCsv':
                    $this->downloadCsv();
                    exit;
                    break;
                case 'switch':
                    $this->submissionSwitch();
                    break;
            }
        } else {
            $this->ranks = $this->getRanking(true, true);
        }


        $this->render('rankview', array(
            'contest' => $this->contest,
            'ranks' => $this->ranks,
            'supervisor' => $this->supervisor
        ));
    }

    public function downloadCsv() {
        header('Content-type: text/csv');
        $date = date('YmdHis', time());
        header('Content-Disposition: attachment; filename="ranks-' . $date . '.csv"');
        $ranks = $this->ranks;

        ob_clean();
        echo "Username, Nama, Total, ";
        $aliases = $this->contest->getProblemAliases();
        foreach ($aliases as $alias) {
            echo "P" . $alias . ", ";
        }
        echo "\n";
        foreach ($ranks as $rank) {
            printf("%s,\"%s\",%s,", $rank['username'], $rank['full_name'], $rank['total']
            );
            foreach ($aliases as $alias) {
                echo $rank["P" . $alias] . ",";
            }
            echo "\n";
        };
    }

    public function submissionSwitch() {
        $contest_id = $this->contest->id;
        $submissions = Submission::model()->findAll(array(
            "condition" => "contest_id = $contest_id",
            "order" => "submitted_time ASC"
                ));

        foreach ($submissions as $sub) {
            if ($sub->grade_status == Submission::GRADE_STATUS_GRADED && $sub->getGradeContent('official_result') !== NULL && $sub->getGradeContent('official_output') !== NULL) {
                $sub->setScenario('update');

                $official_result = $sub->getGradeContent('official_result');
                $official_output = $sub->getGradeContent('official_output');

                $sub->setGradeContent('official_result', $sub->score);
                $sub->setGradeContent('official_output', $sub->getGradeContent('output'));

                $sub->score = $official_result;
                $sub->setGradeContent('output', $official_output);

                $sub->save(false);
            }
        }

        $mode = isset($_GET['mode']) ? $_GET['mode'] : '';

        switch ($mode) {
            case 'fullRank':
                $this->ranks = $this->getRanking(false, false, true);
                break;
            default:
                $this->ranks = $this->getRanking(false, false, false);
                break;
        }
    }

    public function getRanking($contestantonly = true, $nonhidden = false, $official = false) {
        //TODO Cache this
        $contest = $this->contest;
        if ($nonhidden) {
            $problems = $contest->nonhiddenproblems;
        } else {
            $problems = $contest->problems;
        }
        //var_dump($problems);
        if ($contestantonly) {
            $members = $contest->contestants;
        } else {
            $members = $contest->members;
            array_push($members, $contest->owner);
        }
        $ranks = array();
        $aliases = $contest->getProblemAliases();
        $statuses = $contest->getProblemStatuses();
        $arscores = array();
        $lastsubmissions = Submission::getLastContestSubmissions($contest);
        foreach ($lastsubmissions as $s) {
            if ($official)
                $arscores[$s->submitter_id][$s->problem_id] = $s->getGradeContent('official_result');
            else
                $arscores[$s->submitter_id][$s->problem_id] = $s->score;
        }
        $rr = array();
        foreach ($members as $member) {
            $rank = array(
                'id' => $member->id,
                'username' => $member->username,
                'full_name' => $member->full_name,
            );
            $total = 0;
            foreach ($problems as $problem) {
                //echo $problem->title;
                $score = isset($arscores[$member->id][$problem->id]) ? $arscores[$member->id][$problem->id] : 0;
                $total = $total + $score;
                $rank['P' . $aliases[$problem->id]] = $score;
            }

            $rank['total'] = $total;
            $rank['rank'] = 0;
            $rr[] = $total;
            $ranks[] = $rank;
        }
        array_multisort($rr, SORT_DESC, $ranks);

        $prev = 1;
        for ($i = 0; $i < count($ranks); $i++) {
            if ($i > 0 && $ranks[$i]['total'] == $ranks[$i - 1]['total'])
                $ranks[$i]['rank'] = $prev;
            else {
                $ranks[$i]['rank'] = $i + 1;
                $prev = $i + 1;
            }
        }

        return $ranks;
    }

}
