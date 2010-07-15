<?php

class StatisticsController extends CContestController {

    public $layout = 'application.views.layouts.contestsupervisor';
    public $defaultAction = 'activity';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'expression' => 'Yii::app()->controller->isSupervisor()'
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionRank() {
        //TODO: Cache this
        /*if ($this->getContest()->contest_type_id == 1) {
            $ranks = $this->getContest()->getRanking(false, false);
        } else {
            $ranks = $this->getContest()->getACMICPCRanking(false, false);
        }*/
//	var_dump($ranks);

        if (isset($_GET['zoom']) && $_GET['zoom'] == 'zoom') {
            $this->layout = 'application.views.layouts.column1';
            $this->render('rank_zoom', array('ranks' => $ranks));
        } else {
            //$this->render('rank', array('ranks' => $ranks));
            $this->render('rank');
        }
    }
    
    public function actionMemberLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $query = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->join = "JOIN contests_users ON user_id = id";
            $criteria->condition = "(id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm) AND contest_id = :contestid";
            $criteria->params = array(
                ":sterm" => "%$query%",
                ":contestid" => $this->getContest()->id
            );
            $users = User::model()->findAll($criteria);
            $users[] = $this->getContest()->owner;
            $retval = array();
            foreach($users as $user)
            {
                $retval[] = array(
                    'value' => $user->getAttribute('id'),
                    'label' => $user->getAttribute('id').'. '.
                        $user->getAttribute('full_name').' ('.
                        $user->getAttribute('username').'/'.
                        $user->getAttribute('email').')',
                );
            }
            echo CJSON::encode($retval);
        }
    }

    public function actionFullRank() {
        $ranks = $this->getContest()->getFullRanking(false, false);

        $this->render('rank', array('ranks' => $ranks));
    }

    public function actionDownloadRank() {
        header('Content-type: text/csv');
        $date = date('YmdHis', time());
        header('Content-Disposition: attachment; filename="ranks-' . $date . '.csv"');
        $ranks = $this->getContest()->getRanking();
        $this->renderPartial('csv/rank', array('ranks' => $ranks));
    }

    public function actionDownloadFullRank() {
        header('Content-type: text/csv');
        $date = date('YmdHis', time());
        header('Content-Disposition: attachment; filename="ranks-' . $date . '.csv"');
        $ranks = $this->getContest()->getFullRanking();
        $this->renderPartial('csv/rank', array('ranks' => $ranks));
    }

    public function actionActivity() {
        $activities = $this->getContest()->getMemberActivites();
        $dataProvider = new CArrayDataProvider($activities, array(
                    'id' => 'id',
                    'sort' => array(
                        'attributes' => array(
                            'last_activity', 'id', 'username', 'last_page'
                        ),
                    ),
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        $this->render('activity', array('dataProvider' => $dataProvider));
    }

    public function actionDownloadActivity() {
        header('Content-type: text/csv');
        $date = date('YmdHis', time());
        header('Content-Disposition: attachment; filename="activities-' . $date . '.csv"');
        $activities = $this->getContest()->getMemberActivites();
        $this->renderPartial('csv/activity', array('activities' => $activities));
    }

	public function actionLog() {
		$logs = $this->getContest()->logs;
		$contest = $this->getContest();

		$criteria = new CDbCriteria();
		$criteria->condition = "contest_id = $contest->id";
		$criteria->order = "time DESC";
		if (isset($_GET['filtercontestant'])){
            if (($uid = $_GET['filtercontestant']) != 'all'){
                $criteria->addCondition('actor_id = '.$uid);
            }
        }

		$dataProvider = new CActiveDataProvider('ContestLog', array(
			'id' => 'id',
			
			'pagination' => array(
				'pageSize' => 20,
			),
			'criteria' => $criteria
		));
		$this->render('log' , array('dataProvider' => $dataProvider));
	}

}
