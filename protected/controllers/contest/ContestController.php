<?php

class ContestController extends CController {

    public function actionIndex() {
        $this->layout = 'application.views.layouts.column2';
        $activeContestDataProvider = new CActiveDataProvider('Contest', array(
            'criteria' => array(
                'join' => 'JOIN contests_users ON contest_id = id',
                'condition' => 'user_id = '.Yii::app()->user->getId()
            )
        ));
        $this->render('index', array('activeContestDataProvider' => $activeContestDataProvider ));
    }

    public function actionSignIn(){
        if (isset($_GET['contestid'])){
            $this->redirect(array('contest/news', 'contestid' => $_GET['contestid']));
        } else {
            
        }
    }

    public function actionSignOut(){
        Yii::app()->session->remove('contest');
        $this->redirect(array('/home'));
    }

}
