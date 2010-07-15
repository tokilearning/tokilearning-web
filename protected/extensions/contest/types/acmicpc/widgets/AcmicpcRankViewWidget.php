<?php

class AcmicpcRankViewWidget extends CWidget {

    public $contest;
    private $ranks;
    public $supervisor;
    public $fullRank = false;

    public function run() {
        $this->supervisor = $this->contest->isSupervisor(Yii::app()->user) || $this->contest->owner->id == Yii::app()->user->id || (Yii::app()->user->id && Group::checkMember("administrator", Yii::app()->user));
        if ($this->supervisor) {
            $mode = isset($_GET['mode']) ? $_GET['mode'] : '';

            if ($mode == "fullrank") {
                $this->ranks = $this->getRanking(false, true, true);
            }
            else
                $this->ranks = $this->getRanking(false, true);
        }
        else {
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

    public function getRanking($contestantonly = true, $nonhidden = false, $official = false) {
        $contest = $this->contest;
        if ($nonhidden) {
            $problems = $contest->nonhiddenproblems;
        } else {
            $problems = $contest->problems;
        }
        if ($contestantonly) {
            $members = $contest->contestants;
        } else {
            $members = $contest->members;
            array_push($members, $contest->owner);
        }
        $ranks = array();
        $aliases = $contest->getProblemAliases();
        $statuses = $contest->getProblemStatuses();
        $contest_id = $contest->id;
        $countproblem = count($problems);
        $contest_start_time = strtotime($contest->start_time);

        foreach ($members as $member) {
            $rank_row = array();
            $rank_row["submitter_id"] = $member->id;
            $rank_row["submitter_username"] = $member->username;
            $rank_row["submitter_full_name"] = $member->full_name;
            $rank_row["submitter_institution"] = $member->institution;

            $total_ac = 0;
            $total_penalty = 0;

            foreach ($problems as $problem) {
                $problem_id = $problem->id;
                $submitter_id = $member->id;
                //if ($contestantonly){
                //    $submissions = Submission::model()->findAll(array(
                //        "condition" => "problem_id = $problem_id AND ".
                //                	   "submitter_id = $submitter_id AND ".
                //             	       "contest_id = $contest_id AND ".
                //					   "submitted_time < \"2010-09-25 14:00:00\"",
                //    	"order" => "submitted_time ASC"
                //	));
                //} else {
                if ($official) {
                    $submissions = Submission::model()->findAll(array(
                        "condition" => "problem_id = $problem_id AND " .
                        "submitter_id = $submitter_id AND " .
                        "contest_id = $contest_id",
                        "order" => "submitted_time ASC"
                            ));
                } else {
                    if ($this->contest->getConfig('freezetime') === null) {
                        $this->contest->setConfig('freezetime' , 0);
                        $this->contest->save();
                    }
                    
                    $submissions = Submission::model()->findAll(array(
                        "condition" => "problem_id = $problem_id AND " .
                        "submitter_id = $submitter_id AND " .
                        "contest_id = $contest_id AND
						TIMESTAMPDIFF(SECOND , submitted_time , \"$contest->end_time\") > " . $this->contest->getConfig('freezetime'),
                        "order" => "submitted_time ASC"
                            ));
                }

                //}
                $success = 0;
                $fail = 0;
                $trial = 0;
                $last_submit = 0;
                foreach ($submissions as $submission) {
                    $last_submit = $submission->submitted_time;
                    $trial++;

                    if ($submission->score == 0) {
                        $fail++;
                    } else {
                        $success++;
                        break;
                    }
                }

                $alias = $aliases[$problem->id];
                $rank_row["problem" . $alias . "_trial"] = $trial;
                if ($trial > 0) {
                    if ($contest->span_type == Contest::CONTEST_SPAN_TYPE_VIRTUAL)
                        $contest_start_time = ContestLog::findFirstLog($contest, $member, ContestLog::ACTION_ENTER)->time;

                    $rank_row["problem" . $alias . "_submitted_time"] = ($trial - 1) * 1200 + strtotime($last_submit) - $contest_start_time;
                }
                else
                    $rank_row["problem" . $alias . "_submitted_time"] = 0;
                $rank_row["problem" . $alias . "_accepted"] = $success != 0 ? 1 : 0;

                if ($success != 0) {
                    $total_ac++;
                    $total_penalty += $rank_row["problem" . $alias . "_submitted_time"];
                }
            }
            $rank_row['total_ac'] = $total_ac;
            $rank_row['total_penalty'] = $total_penalty;

            $ranks[] = $rank_row;
        }

        /* $ranks = array(
          array(
          "submitter_id" => "1",
          "problem1" => "",
          "problem2" => "",
          "problem3" => "",
          "problem4" => "",
          "acc_per_time" => ""
          ),
          array(
          "submitter_id" => "1",
          "problem1" => "",
          "problem2" => "",
          "problem3" => "",
          "problem4" => "",
          "acc_per_time" => ""
          ),

          ); */
        uasort($ranks, 'AcmicpcRankViewWidget::compare');

        return $ranks;
    }

    private static function compare($a, $b) {
        if ($a['total_ac'] > $b['total_ac'] || ($a['total_ac'] == $b['total_ac'] && $a['total_penalty'] < $b['total_penalty']))
            return -1;
        else
            return 1;
    }

}
