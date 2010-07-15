<?php

class ContestController extends CSupervisorController {

    private $_model;
    
    public function actionIndex() {
        $criteria = new CDbCriteria;
        $criteria->group = 'id';
        $filter = '';
        if (isset($_GET['filter'])){
            $filter = explode('_', $_GET['filter']);
        } else {
            $filter[0] = 'current';
        }
        if (isset($filter[1]) && $filter[1] == 'active'){
            $criteria->join = "LEFT JOIN contests_users ON id = contest_id";
            $criteria->addCondition("owner_id = ".Yii::app()->user->getId()." OR contests_users.user_id = ".Yii::app()->user->getId());
        }
        switch($filter[0]){
            case 'current':
                $now = new CDbExpression('NOW()');
                $criteria->addCondition('start_time <= '.$now.' AND end_time >= '.$now);
                break;
            case 'past':
                $now = new CDbExpression('NOW()');
                $criteria->addCondition('end_time <= '.$now);
                break;
            case 'all':
            default :
                break;
        }
        $dataProvider = new CActiveDataProvider('Contest', array(
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                    'criteria' => $criteria,
                ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionCreate() {
        $model = new Contest('create');
        if (isset($_POST['Contest'])){
            $model->attributes = $_POST['Contest'];
            $model->start_time = date('Y-m-d H:i:s', strtotime($model->startDate." ".$model->startTime));
            $model->end_time = date('Y-m-d H:i:s', strtotime($model->endDate." ".$model->endTime));
            if ($model->validate()){
                $model->owner_id = Yii::app()->user->id;
                $model->status = Contest::CONTEST_VISIBILITY_HIDDEN;
                $model->save(false);
                $this->redirect(array('contest/supervisor', 'contestid' => $model->id));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionView() {
        $contest = $this->loadModel();
        $this->render('view', array('contest' => $contest));
    }

    public function actionDelete(){
        
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Contest::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}
