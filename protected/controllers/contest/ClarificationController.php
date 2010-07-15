<?php

class ClarificationController extends CContestController {

    public function actionIndex() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'contest_id = '.$this->getContest()->id;
        if (isset($_GET['filterbyproblem'])){
            switch ($_GET['filterbyproblem']){
                case 'all':
                    break;
                case 'others' :
                    $criteria->addCondition('problem_id IS NULL');
                    break;
                default:
                    $pid = $_GET['filterbyproblem'];
                    $problem = $this->getContest()->getProblemByAlias($pid);
                    if ($problem != null){
                        $criteria->addCondition('problem_id = '.$problem->id);
                    }
                    break;
            }
        }
        $dataProvider = new CActiveDataProvider('Clarification', array(
            'pagination' => array(
                'pageSize' => 10,
            ),
            'criteria' => $criteria
        ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionCreate(){
        $model = new Clarification('create');
        if (isset($_POST['Clarification'])){
            $model->attributes = $_POST['Clarification'];
            if ($model->validate()){
                $alias = $_POST['problemalias'];
                if ($alias != -1){
                    $problem = $this->getContest()->getProblemByAlias($alias);
                    $model->problem_id = $problem->id;
                } else {
                    $model->problem_id = NULL;
                }
                $model->questioner_id = Yii::app()->user->getId();
                $model->contest_id = $this->getContest()->id;
                if ($model->save(false)){
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('create', array('model' => $model));
    }

}
