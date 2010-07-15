<?php

class ProblemController extends CContestController {

    private $_model;
    public static $aliases;

    public function actionIndex() {
        $c = new CDbCriteria();
         if ($this->getContest()->hasStarted()) {
             $dataProvider = new CActiveDataProvider('Problem', array(
                'pagination' => array(
                    'pageSize' => 10,
                ),
                'criteria' => array(
                    'join' => 'JOIN contests_problems ON problem_id = id',
                    'condition' => 'contest_id = '.$this->getContest()->id.' AND contests_problems.status != '.Contest::CONTEST_PROBLEM_HIDDEN,
                )
            ));
            $c->join = 'JOIN contests_problems ON problem_id = id';
            $c->condition = 'contest_id = '.$this->getContest()->id.' AND contests_problems.status != '.Contest::CONTEST_PROBLEM_HIDDEN;
         }
         else {
             $dataProvider = new CActiveDataProvider('Problem', array(
                'pagination' => array(
                    'pageSize' => 10,
                ),
                'criteria' => array(
                    'join' => 'JOIN contests_problems ON problem_id = id',
                    'condition' => 'NULL',
                )
            ));
            $c->join = 'JOIN contests_problems ON problem_id = id';
            $c->condition = 'NULL';
         }

        $problems = Problem::model()->findAll($c);

        ProblemController::$aliases = array();
        foreach ($problems as $p)
            ProblemController::$aliases[$p->id] = $this->contest->getProblemAlias($p);
        
        uasort($problems , "ProblemController::comp");

        $dataProvider = new CArrayDataProvider($problems);
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    private static function comp($a , $b) {
        if (ProblemController::$aliases[$a->id] < ProblemController::$aliases[$b->id])
            return -1;
        else
            return 1;
    }

    public function actionView() {
		$model = $this->loadModel();
		//ContestLog::readProblem(Yii::app()->user->id, $this->getContest()->id, $model->id);
        $this->render('view', array('model' => $model));
    }

    public function actionSubmissions(){
        $model = $this->loadModel();
        $submissionDataProvider = new CActiveDataProvider('Submission', array(
            'pagination' => array(
                'pageSize' => 20,
            ),
            'criteria' => array(
                'select' => array('id', 'submitted_time', 'grade_status' , 'verdict'),
                'condition' => 'contest_id = :contest_id AND problem_id = :problem_id AND submitter_id = :submitter_id',
                'params' => array(
                    'problem_id' => $model->id,
                    'submitter_id' => Yii::app()->user->getId(),
                    'contest_id' => $this->getContest()->id
                ),
            )
        ));
        $this->render('submissions', array(
            'model' => $model,
            'submissionDataProvider' => $submissionDataProvider
            ));
    }

    public function isProblemHidden(){
        return $this->getContest()->getProblemStatus($this->_model) == Contest::CONTEST_PROBLEM_HIDDEN;
    }

    public function isProblemOpen(){
        return $this->getContest()->getProblemStatus($this->_model) == Contest::CONTEST_PROBLEM_OPEN;
    }

    public function isProblemClosed(){
        return $this->getContest()->getProblemStatus($this->_model) == Contest::CONTEST_PROBLEM_CLOSED;
    }

    public function getProblemAlias($problem){
        return $this->getContest()->getProblemAlias($problem);
    }

    private function loadModel(){
        if ($this->_model === null) {
            if (isset($_GET['alias']))
                $this->_model = $this->getContest()->getProblemByAlias($_GET['alias']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            if ($this->isProblemHidden($this->_model)){
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$this->getContest()->hasStarted())
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}
