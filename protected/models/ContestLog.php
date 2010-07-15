<?php

class ContestLog extends CActiveRecord {

	const ACTION_ENTER = 0;
	const ACTION_LEAVE = 1;
	const ACTION_READ = 2;
	const ACTION_SUBMIT = 3;
	const ACTION_REQUEST_CLARIFICATION = 4;

	public static function model($className=__CLASS__) {
        return parent::model($className);
    }

	public function tableName() {
        return '{{contest_logs}}';
    }

	public function relations(){
        return array(
            'actor' => array(self::BELONGS_TO, 'User', 'actor_id'),
            'contest' => array(self::BELONGS_TO, 'Contest', 'contest_id'),
        );
    }

	public function beforeSave(){
        if ($this->isNewRecord) {
            $this->time = time();
        }
        return parent::beforeSave();
    }

	public static function findFirstLog($pContest , $pActor , $pType) {
		$timeOffset = strtotime($pContest->start_time);
		$criteria = new CDbCriteria();
		$criteria->condition = "contest_id = $pContest->id AND actor_id = $pActor->id AND action_type = $pType AND time >= $timeOffset";
		$criteria->order = "time ASC LIMIT 1;";

		return ContestLog::model()->find($criteria);
	}

    public function getActionText() {
        $tAction = $this->action_type;    
    
        switch ($tAction) {
			case self::ACTION_ENTER : return "Masuk kontes";break;
			case self::ACTION_LEAVE : return "Tinggalkan kontes";break;
			case self::ACTION_SUBMIT : return "Mengumpulkan jawaban";break;
			case self::ACTION_READ : return "Membuka soal";break;
			case self::ACTION_REQUEST_CLARIFICATION : return "Minta klarifikasi";break;
			default :
			    return $this->contest->getContestTypeHandler()->getContestLogText($this);
			    break;
		}
    }

	/*public static function getActionText($pAction) {
		switch ($pAction) {
			case self::ACTION_ENTER : return "Masuk kontes";break;
			case self::ACTION_LEAVE : return "Tinggalkan kontes";break;
			case self::ACTION_SUBMIT : return "Mengumpulkan jawaban";break;
			case self::ACTION_READ : return "Membuka soal";break;
			case self::ACTION_REQUEST_CLARIFICATION : return "Minta klarifikasi";break;
			default : return "";break;
		}
	}*/

	public function getRemarksText() {
		if ($this->action_type == self::ACTION_SUBMIT) {
			$info = json_decode($this->log_content , true);
			//return $info['submission_id'];
			$submission = Submission::model()->findByPK($info['submission_id']);
			return CHtml::link($submission->problem->title, array('contest/supervisor/submission/update/id/' . $submission->id));
		}
		else
			return $this->contest->getContestTypeHandler()->getContestLogRemarks($this);
	}

	public static function enterContest($pUserID , $pContestID) {
		$tContestLog = new ContestLog('Create');
		$tContestLog->contest_id = $pContestID;
		$tContestLog->actor_id = $pUserID;
		$tContestLog->action_type = self::ACTION_ENTER;
		$tContestLog->save();
	}

	public static function startContest($pUserID , $pContestID) {
		$tContestLog = new ContestLog('Create');
		$tContestLog->contest_id = $pContestID;
		$tContestLog->actor_id = $pUserID;
		$tContestLog->action_type = self::ACTION_START_CONTEST;
		$tContestLog->save();
	}

	public static function leaveContest($pUserID , $pContestID) {
		$tContestLog = new ContestLog('Create');
		$tContestLog->contest_id = $pContestID;
		$tContestLog->actor_id = $pUserID;
		$tContestLog->action_type = self::ACTION_LEAVE;
		$tContestLog->save();
	}

	public static function readProblem($pUserID , $pContestID , $pProblemID) {
		$tContestLog = new ContestLog('Create');
		$tContestLog->contest_id = $pContestID;
		$tContestLog->actor_id = $pUserID;
		$tContestLog->action_type = self::ACTION_READ;
		$tContestLog->log_content = json_encode(array('problem_id' => $pProblemID));
		$tContestLog->save();
	}

	public static function submitSolution($pUserID , $pContestID , $pSubmissionID) {
		$tContestLog = new ContestLog('Create');
		$tContestLog->contest_id = $pContestID;
		$tContestLog->actor_id = $pUserID;
		$tContestLog->action_type = self::ACTION_SUBMIT;
		$tContestLog->log_content = json_encode(array('submission_id' => $pSubmissionID));
		$tContestLog->save();
	}
}
