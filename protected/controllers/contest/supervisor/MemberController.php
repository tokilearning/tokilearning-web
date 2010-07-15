<?php

class MemberController extends CContestController {

    public $layout = 'application.views.layouts.contestsupervisor';

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
		if (isset($_FILES['csvfile'])) {
			$handle = fopen($_FILES['csvfile']['tmp_name'] , "r");

			while ($line = fgets($handle)) {
				$username = substr($line , 0 , strlen($line) - 1);
				$criteria = new CDbCriteria;
				$criteria->condition = "username LIKE \"%$username%\"";
				$user = User::model()->find($criteria);

				if (isset($_POST['remove']))
					$this->getContest()->removeContestant($user);
				else
					$this->getContest()->addContestant($user);
			}

			fclose($handle);
		}


        $contestantsDataProvider = new CActiveDataProvider('User', array(
            'pagination' => array(
                'pageSize' => 10,
            ),
            'criteria' => array(
                'join' => 'JOIN contests_users ON user_id = id',
                'condition' => 'role = :role AND contest_id = :contest_id',
                'params' => array(
                    'role' => Contest::CONTEST_MEMBER_CONTESTANT,
                    'contest_id' => $this->getContest()->id
                )
            )
        ));
        $supervisorsDataProvider = new CActiveDataProvider('User', array(
            'pagination' => array(
                'pageSize' => 10,
            ),
            'criteria' => array(
                'join' => 'JOIN contests_users ON user_id = id',
                'condition' => 'role = :role AND contest_id = :contest_id',
                'params' => array(
                    'role' => Contest::CONTEST_MEMBER_SUPERVISOR,
                    'contest_id' => $this->getContest()->id
                )
            )
        ));
        $registrantsDataProvider = new CActiveDataProvider('User', array(
            'pagination' => array(
                'pageSize' => 10,
            ),
            'criteria' => array(
                'join' => 'JOIN contests_users ON user_id = id',
                'condition' => 'role = :role AND contest_id = :contest_id',
                'order' => 'register_date ASC',
                'params' => array(
                    'role' => Contest::CONTEST_MEMBER_REGISTRANT,
                    'contest_id' => $this->getContest()->id
                )
            )
        ));
        $this->render('index', array(
            'contestantsDataProvider' => $contestantsDataProvider,
            'supervisorsDataProvider' => $supervisorsDataProvider,
            'registrantsDataProvider' => $registrantsDataProvider,
        ));
    }

    public function actionContestantLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $query = $_GET['term'];
            $criteria = new CDbCriteria;

            if (isset($_GET['contestantfilter'])) {
                $criteria->join = "JOIN contests_users ON contests_users.user_id = id";
                $criteria->condition = "(id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm) AND contest_id = " . $this->contest->id;
            }
            else {
                $criteria->join = "JOIN groups_users ON user_id = id";
                $criteria->condition = "(id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm) AND group_id = :groupid";
            }

            //$criteria->condition = "(id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm) AND group_id = :groupid";
            $criteria->params = array(
                ":sterm" => "%$query%",
                ":groupid" => 3,
            );
            $users = User::model()->findAll($criteria);
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

    public function actionSupervisorLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $query = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->join = "JOIN groups_users ON user_id = id";
            $criteria->condition = "(id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm)";
            $criteria->params = array(
                ":sterm" => "%$query%",
                ":groupid" => 2,
            );
            $users = User::model()->findAll($criteria);
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

    public function actionAddContestant(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['memberid'])){
            $user = User::model()->findByPk($_GET['memberid']);
            if ($user != null && Group::checkMember("learner", $user)) {
                $this->getContest()->addContestant($user);
            }
        }
    }

    public function actionRemoveContestant(){
        if (Yii::app()->request->isPostRequest && isset($_GET['memberid'])){
            $user = User::model()->findByPk($_GET['memberid']);
            if ($user != null){
                $this->getContest()->removeContestant($user);
            }
        }
    }
    
    public function actionAddSupervisor(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['memberid'])){
            $user = User::model()->findByPk($_GET['memberid']);
            if ($user != null){
                $this->getContest()->addSupervisor($user);
            }
        }
    }

    public function actionRemoveSupervisor(){
        if (Yii::app()->request->isPostRequest && isset($_GET['memberid'])){
            $user = User::model()->findByPk($_GET['memberid']);
            if ($user != null){
                $this->getContest()->removeSupervisor($user);
            }
        }
    }

    public function actionApproveRegistrants(){
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest){
            if (isset($_POST['mark'])){
                foreach($_POST['mark'] as $registrantid){
                    $registrant = User::model()->findByPk($registrantid);
                    $this->getContest()->addContestant($registrant);
                }
            }
        }
    }

    public function actionBatchAddContestants() {
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {
            if ($_POST){
                $prefix = $_POST['prefix'];
                $postfix = $_POST['postfix'];
                $start = $_POST['start'];
                $end = $_POST['end'];
                $d = $_POST['digit'];

                for ($i = $start ; $i <= $end ; $i++) {
                    $username = sprintf("%s%0".$d."d%s", $prefix, $i, $postfix);
                    $user = User::model()->find(array('condition' => "username = '$username'"));

                    if (isset($user)) {
                        $this->getContest()->addContestant($user);
                    }
                }
            }
        }
    }


    public function actionBatchRemoveContestants() {
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest){
            if ($_POST){
                $prefix = $_POST['prefix'];
                $postfix = $_POST['postfix'];
                $start = $_POST['start'];
                $end = $_POST['end'];
                $d = $_POST['digit'];

                for ($i = $start ; $i <= $end ; $i++) {
                    $username = sprintf("%s%0".$d."d%s", $prefix, $i, $postfix);
                    $user = User::model()->find(array('condition' => "username = '$username'"));

                    if (isset($user)) {
                        $this->getContest()->removeContestant($user);
                    }
                }
            }
        }
    }


    public function actionRejectRegistrants(){
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest){
            if (isset($_POST['mark'])){
                foreach($_POST['mark'] as $registrantid){
                    $registrant = User::model()->findByPk($registrantid);
                    $this->getContest()->removeRegistrant($registrant);
                }
            }
        }
    }

}
