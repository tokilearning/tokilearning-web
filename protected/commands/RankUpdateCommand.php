<?php

class RankUpdateCommand extends CConsoleCommand {
	private $url;
	private $delay;
	private $contest;
	private $curlChannel;

	private function sendRanking($rankingDetail) {
		$rankingDetail = urlencode($rankingDetail);
		curl_setopt($this->curlChannel, CURLOPT_POST, 1);
        curl_setopt($this->curlChannel, CURLOPT_POSTFIELDS, "rankingdetail=$rankingDetail");
		curl_setopt($this->curlChannel , CURLOPT_URL , $this->url/* . "?rankingdetail=$rankingDetail"*/);
        curl_setopt($this->curlChannel , CURLOPT_RETURNTRANSFER , 1);
		$content = curl_exec($this->curlChannel);
		echo $content;
	}

    public function run($args) {
		if (count($args) != 3) {
			echo "Wrong arguments given\nrankupdate http://tokilearning.org/rankupdate <interval> <contestid>";
			return;
		}

		$this->url = $args[0];
		$this->delay = $args[1] * 60;
		$this->contest = Contest::model()->findByPK($args[2]);

		if ($this->contest === null) {
			echo "Contest not found\n";
			return;
		}

        echo "Rank updater running...\n";
		$this->curlChannel = curl_init();

		while (true) {
			//echo json_encode($this->getPublicRanking()) . "\n";
			//print_r($this->getProblems());
			$this->contest = Contest::model()->findByPK($args[2]);
			$this->sendRanking(json_encode(array(
				'ranking' => $this->getPublicRanking(true,false,true),
				'problems' => $this->getProblems(),
				'timestamp' => time()
			)));

			sleep($this->delay);
		}
    }

	public function getProblems() {
		$problems = $this->contest->nonhiddenproblems;

		$retval = array();
		foreach ($problems as $problem) {
			$retval[$this->contest->getProblemAlias($problem)] = $problem->title;
		}
		return $retval;
	}

	public function getPublicRanking($contestantonly = true, $nonhidden = false , $official = false) {
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

            /*if (!$contest->hasEnded()) {
				if ($contest->getConfig('secret')) {
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
            }*/
        }
		else {
            $members = $contest->members;
            array_push($members, $contest->owner);
        }


        $ranks = array();
        $aliases = $contest->getProblemAliases();
        $statuses = $contest->getProblemStatuses();
        $arscores = array();
        //$lastsubmissions = Submission::getLastContestSubmissions($contest);
	$lastsubmissions = $contest->getContestTypeHandler()->getRankedSubmissions($contest , true);

	$tokened = array();
        foreach ($lastsubmissions as $s) {
            //echo $s->getSubmitContent('fullfeedback') . " ";

            if ($official)
                $arscores[$s->submitter_id][$s->problem_id] = $s->getGradeContent('official_result');
            else
                $arscores[$s->submitter_id][$s->problem_id] = $s->score;

	    $tokened[$s->submitter_id][$s->problem_id] = $s->getSubmitContent('fullfeedback');
        }
        $rr = array();
        $i = 0;
        foreach ($members as $member) {
            $i++;
            $rank = array(
                'id' => $member->id,
                'username' => $member->username,
                'full_name' => $member->full_name,
		'city' => $member->city,
		'token' => $contest->getContestTypeHandler()->getAvailableTokensFor(User::model()->findByPK($member->id))
            );
            $total = 0;
            foreach ($problems as $problem) {
                //echo $problem->title;
                $score = isset($arscores[$member->id][$problem->id]) ? $arscores[$member->id][$problem->id] : 0;
		$isTokened = isset($tokened[$member->id][$problem->id]) ? $arscores[$member->id][$problem->id] : false;

                $total = $total + $score;

		if (!$isTokened)
		    $rank['P' . $aliases[$problem->id]] = $score;
		else
		    $rank['P' . $aliases[$problem->id]] = $score . " (T)";
				//$rank[$problem->id] = $score;
            }

            $rank['total'] = $total;
            $rank['rank'] = $i;
            $rr[] = $total;
            $ranks[] = $rank;
        }
        array_multisort($rr, SORT_DESC, $ranks);

        $prev = 1;
		for ($i = 0 ; $i < count($ranks) ; $i++) {
			if ($i > 0 && $ranks[$i]['total'] == $ranks[$i - 1]['total'])
				$ranks[$i]['rank'] = $prev;
			else {
				$ranks[$i]['rank'] = $i + 1;
				$prev = $i + 1;
			}

			$ranks[$i]['actualrank'] = $i + 1;
        }

		/*for ($i = 1 ; $i < 50 ; $i++) {
			$ranks[] = $ranks[0];
			$ranks[$i]['rank'] = $i + 1;
			$ranks[$i]['actualrank'] = $i + 1;
		}*/

        return $ranks;
    }

}
