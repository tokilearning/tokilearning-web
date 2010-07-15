<?php

class ContestController extends CMemberController {

    public function actionIndex() {
        $this->layout = 'application.views.layouts.column2';
        $activeContestDataProvider = new CActiveDataProvider('Contest', array(
                    'criteria' => array(
                        'join' => 'JOIN contests_users ON contest_id = id',
                        'condition' => 'user_id = ' . Yii::app()->user->getId() . ' AND end_time >= NOW()',
                    )
                ));
        $publicContestDataProvider = new CActiveDataProvider('Contest', array(
                    'criteria' => array(
                        'condition' => 'status = ' . Contest::CONTEST_VISIBILITY_PUBLIC . ' AND end_time >= NOW()',
                    )
                ));
        $this->render('index', array(
            'activeContestDataProvider' => $activeContestDataProvider,
            'publicContestDataProvider' => $publicContestDataProvider,
        ));
    }
    
    public function actionView() {
        if (isset($_GET['contestid'])) {
            $model = Contest::model()->findByPK($_GET['contestid']);
            if ($model !== null) {
                if (!$model->isMember(Yii::app()->user))
                    throw new CHttpException(403 , "Unauthorized access");            
            
                $dataProvider = new CActiveDataProvider('ContestNews', array(
                    'criteria'=>array(
                        'condition' => 'status = :status AND contest_id = :contestid',
                        'params'=>array(
                            'status' => ContestNews::STATUS_PUBLISHED,
                            'contestid' => $model->id
                        ),
                        'with'=>array('author'),
                    ),
                    'pagination'=>array(
                        'pageSize'=>20,
                    ),
                ));            
            
                $this->render('view' , array(
                    'model' => $model,
                    'dataProvider' => $dataProvider                
                ));
            }
            else {
                throw new CHttpException(404 , "Contest not found");            
            }        
        }
    }

    public function actionList() {
        $this->layout = 'application.views.layouts.column2';
        $filter = $_GET['filter'];
        if (isset($filter)) {
            $criteria = new CDbCriteria;
            switch ($filter) {
                case 'active' :
                    $criteria->join = "LEFT JOIN contests_users ON id = contest_id";
                    $criteria->addCondition("owner_id = " . Yii::app()->user->getId() . " OR contests_users.user_id = " . Yii::app()->user->getId());
                    $criteria->distinct = true;
					break;
                case 'all' :
                    $criteria->addCondition('status = ' . Contest::CONTEST_VISIBILITY_PUBLIC);
                    $criteria->addCondition('end_time <= NOW()');
					$criteria->distinct = true;
					break;
                default:
                    throw new CHttpException(404, 'The requested page does not exist.');
            }
            $dataProvider = new CActiveDataProvider('Contest', array(
                        'pagination' => array(
                            'pageSize' => 10,
                        ),
                        'criteria' => $criteria,
                    ));
            $this->render('list', array('dataProvider' => $dataProvider, 'filter' => $filter));
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionSignIn() {
        if (isset($_GET['contestid'])) {
            /*$contest = Contest::model()->findByPk($_GET['contestid']);
            $handler = ContestType::getHandler($contest);
            $handler->initiate($contest);*/
            $contest = Contest::model()->findByPK($_GET['contestid']);
            if ($contest !== null) {
                if ($contest->isContestant(Yii::app()->user) && $contest->hasStarted() || ($contest->isOwner(Yii::app()->user) || $contest->isSupervisor(Yii::app()->user)))
			        ContestLog::enterContest(Yii::app()->user->id, $_GET['contestid']);            
            
    			if (($contest->isOwner(Yii::app()->user) || $contest->isSupervisor(Yii::app()->user))) {
                    $this->redirect(array('contest/supervisor', 'contestid' => $_GET['contestid']));
                }
                else {
                    $this->redirect(array('contest/news', 'contestid' => $_GET['contestid']));
                }
            }
            else {
                $this->redirect(array('contest/news', 'contestid' => $_GET['contestid']));
            }
        } else {
            $this->redirect(array('index'));
        }
    }

    public function actionSignOut() {
		ContestLog::leaveContest(Yii::app()->user->id, $_GET['contestid']);
        Yii::app()->session->remove('contest');
        $this->redirect(array('/home'));
    }

    public function actionRegister() {
        if (isset($_GET['contestid'])) {
            $contest = Contest::model()->findByPk($_GET['contestid']);
            if ($contest == null) {
                $this->redirect(array('index'));
            } else {
                $contest->registerUser(Yii::app()->user->getRecord());
                Yii::app()->user->setFlash('contestRegisterSucces', $contest);
                $this->redirect(array('index'));
            }
        } else {
            $this->redirect(array('index'));
        }
    }

}
