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
        $this->render('index', array(
            'contestantsDataProvider' => $contestantsDataProvider,
            'supervisorsDataProvider' => $supervisorsDataProvider
        ));
    }

    public function actionContestantLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])){
            $query = $_GET['q'];
            $limit = min($_GET['limit'], 10);
            $criteria = new CDbCriteria;
            $criteria->join = "JOIN groups_users ON user_id = id";
            $criteria->condition = "(id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm) AND group_id = :groupid";
            $criteria->params = array(
                ":sterm" => "%$query%",
                ":groupid" => 3,
            );
            $criteria->limit = $limit;
            $users = User::model()->findAll($criteria);
            $retval = '';
            foreach($users as $user)
            {
                $retval .= $user->getAttribute('id'). '. '
                        .$user->getAttribute('full_name').' ('
                        .$user->getAttribute('username').' / '
                        .$user->getAttribute('email')
                        . ')'.'|'.$user->getAttribute('id')."\n";
            }
            echo $retval;
        }
    }

    public function actionSupervisorLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])){
            $query = $_GET['q'];
            $limit = min($_GET['limit'], 10);
            $criteria = new CDbCriteria;
            $criteria->join = "JOIN groups_users ON user_id = id";
            $criteria->condition = "(id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm) AND group_id = :groupid";
            $criteria->params = array(
                ":sterm" => "%$query%",
                ":groupid" => 2,
            );
            $criteria->limit = $limit;
            $users = User::model()->findAll($criteria);
            $retval = '';
            foreach($users as $user)
            {
                $retval .= $user->getAttribute('id'). '. '
                        .$user->getAttribute('full_name').' ('
                        .$user->getAttribute('username').' / '
                        .$user->getAttribute('email')
                        . ')'.'|'.$user->getAttribute('id')."\n";
            }
            echo $retval;
        }
    }

    public function actionAddContestant(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['memberid'])){
            $user = User::model()->findByPk($_GET['memberid']);
            if ($user != null){
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

}
