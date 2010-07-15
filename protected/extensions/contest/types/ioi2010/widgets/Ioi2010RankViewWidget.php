<?php

class Ioi2010RankViewWidget extends CWidget {

    public $contest;
    private $ranks;
    public $fullRank = false;

    public function run() {
        ///Role selection
        $supervisor = $this->contest->isSupervisor(Yii::app()->user) || Yii::app()->user->id == $this->contest->owner->id || (Yii::app()->user->id && Group::checkMember("administrator", Yii::app()->user));
        if ($supervisor) {
            $action = isset($_GET['action']) ? $_GET['action'] : '';
            $mode = isset($_GET['mode']) ? $_GET['mode'] : '';
            $this->fullRank = $mode == "fullRank";

            switch ($this->fullRank) {
                case true:
                    $this->ranks = $this->getRanking(true, false, true);
                    break;
                case false:
                    $this->ranks = $this->getRanking(true, false, false);
                    break;
            }

            switch ($action) {
                case 'downloadCsv':
                    $this->downloadCsv();
                    exit;
                    break;
                /* case 'switch':
                  $this->submissionSwitch();
                  break; */
                case 'downloadContestants':
                    $this->downloadContestants();
                    break;
                case 'clearCache':
                    $this->contest->getContestTypeHandler()->clearSubmissionsCache();
                    break;
            }
        } else if ($this->contest->isContestant(Yii::app()->user)) {
            $this->ranks = $this->getRanking(true, true);
        } else { //observer
            $this->ranks = $this->getRanking(true, true, false);
        }

        Yii::import('ext.contest.types.ioi2010.Ioi2010Rules');
        $this->render('rankview', array(
            'contest' => $this->contest,
            'ranks' => $this->ranks,
            'supervisor' => $supervisor,
            'fullRank' => $this->fullRank
                //'avTokens' => Ioi2010Rules::getAvailableTokens($this->contest, Yii::app()->user)
        ));
    }

    public function downloadContestants() {
        header('Content-type: text/csv');
        $date = date('YmdHis', time());
        header('Content-Disposition: attachment; filename="ranks-' . $date . '.csv"');
        $contestants = $this->contest->contestants;

        ob_clean();

        echo '"id","Username","Full Name","Email","No telp","Alamat" ,"Provinsi/Kota","Institusi","Alamat Institusi","Telepon Institusi","Informasi Tambahan"' . "\n";
        foreach ($contestants as $contestant) {
            printf('%d,"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"', $contestant->id, $contestant->username, $contestant->full_name, $contestant->email, $contestant->phone, $contestant->address, $contestant->city, $contestant->institution, $contestant->institution_address, $contestant->institution_phone, $contestant->additional_information);
            echo "\n";
        }
        exit;
    }

    public function downloadCsv() {
        header('Content-type: text/csv');
        $date = date('YmdHis', time());
        header('Content-Disposition: attachment; filename="ranks-' . $date . '.csv"');
        $ranks = $this->ranks;

        ob_clean();
        echo "Rank,id,Username,Nama,Total, ";
        $aliases = $this->contest->getProblemAliases();
        foreach ($aliases as $alias) {
            echo "P" . $alias . ", ";
        }
        echo "\n";
        foreach ($ranks as $rank) {
            printf("%d,%d,%s,\"%s\",%s,", $rank['rank'], $rank['id'], $rank['username'], $rank['full_name'], $rank['total']
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
            //if ($sub->grade_status == Submission::GRADE_STATUS_GRADED && $sub->getGradeContent('official_result') !== NULL && $sub->getGradeContent('official_output') !== NULL) {
            $sub->setScenario('update');

            /* $official_result = $sub->getGradeContent('official_result');
              $official_output = $sub->getGradeContent('official_output');

              $sub->setGradeContent('official_result' , $sub->score);
              $sub->setGradeContent('official_output' , $sub->getGradeContent('output'));

              $sub->score = $official_result; */
            $released = $sub->getSubmitContent('fullfeedback') !== NULL ? $sub->getSubmitContent('fullfeedback') : false;
            $sub->setSubmitContent('fullfeedback', !$released);

            $sub->save(false);
            //}
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
            //if (!$contest->hasEnded()) {
            if ($contest->getConfig('secret') && $contest->isContestant(Yii::app()->user)) {
                $c = null;
                foreach ($members as $member) {
                    if ($member->id == Yii::app()->user->id)
                        $c = $member;
                }
                if ($c !== null)
                    $members = array($c);
                else
                    $members = array();
            }
            else if (!$contest->getConfig('secret')) {
                $members = $contest->contestants;
                $official = true;
            }
            //}
        } else {
            $members = $contest->members;
            array_push($members, $contest->owner);
        }


        $ranks = array();
        $aliases = $contest->getProblemAliases();
        $statuses = $contest->getProblemStatuses();
        $arscores = array();

        $lastsubmissions = $contest->getContestTypeHandler()->getRankedSubmissions($contest, $official);


        foreach ($lastsubmissions as $s) {
            //echo $s->getSubmitContent('fullfeedback') . " ";

            /* if ($s->getSubmitContent('fullfeedback'))
              $arscores[$s->submitter_id][$s->problem_id] = $s->score;
              else */if ($official)
                $arscores[$s->submitter_id][$s->problem_id] = $s->getGradeContent('official_result');
            else
                $arscores[$s->submitter_id][$s->problem_id] = $s->score;
        }
        $rr = array();
        $i = 0;
        foreach ($members as $member) {
            $i++;
            $rank = array(
                'id' => $member->id,
                'username' => $member->username,
                'full_name' => $member->full_name,
                'institution' => $member->institution,
            );
            $total = 0;
            $totalOpen = 0;
            foreach ($problems as $problem) {
                //echo $problem->title;
                $score = isset($arscores[$member->id][$problem->id]) ? $arscores[$member->id][$problem->id] : 0;
                $total = $total + $score;
                $rank['P' . $aliases[$problem->id]] = $score;
                
                if ($this->contest->getProblemStatus($problem) == Contest::CONTEST_PROBLEM_OPEN)
                    $totalOpen += $score;
            }

            $rank['total'] = $total;
            $rank['totalOpen'] = $totalOpen;
            $rank['rank'] = $i;
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
