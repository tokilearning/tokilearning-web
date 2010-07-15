<?php


class TrainingController extends CMemberController {

    private $_model;
    public $trainingId;
    public $pageTitle = "Latihan";
    public $training;
    public $chapter;
    public $problem;

    /**
     * 
     */
    public function actionIndex(){
		throw new CHttpException(404, 'The requested page doesn\'t exist');
        $criteria = new CDbCriteria;
        $criteria->addCondition("status = " . Training::STATUS_OPEN);
        $dataProvider = new CActiveDataProvider('Training', array(
            'pagination' => array(
                'pageSize' => 20,
            ),
            'criteria' => $criteria
        ));

        $this->render('index' , array('dataProvider' => $dataProvider));
    }

    /**
     * 
     */
    public function actionView(){
        $training = $this->loadTraining();
        $this->pageTitle = $training->name;
        $chapters = $training->chapters;
        $dataProvider = new CArrayDataProvider($chapters);
        $this->render('view', array(
            'training' => $training,
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * View Chapter
     */
    public function actionViewChapter(){
        $training = $this->loadTraining();
        $chapter = $this->loadChapter();
        $clarModel = new Clarification();

        if ($chapter->isAccessible(Yii::app()->user , $training)) {
            $this->pageTitle = $chapter->name;
            $problems = $chapter->problems;
            $problemDataProvider = new CArrayDataProvider($problems);
            $clarificationDataProvider = new CArrayDataProvider($chapter->clarifications);
            $subchapters = $chapter->getSubChapters();
            $subchapterDataProvider = new CArrayDataProvider($subchapters);
            $chapter->openBy(Yii::app()->user);
            $this->render('view_chapter', array(
                'training' => $training,
                'chapter' => $chapter,
                'subchapterDataProvider' => $subchapterDataProvider,
                'problemDataProvider' => $problemDataProvider,
                'clarificationDataProvider' => $clarificationDataProvider,
                'clarModel' => $clarModel
            ));
        }
        else
            throw new CHttpException(403, 'You are not allowed to open this chapter yet');
    }

    public function actionCreateClarification($id) {
        $chapter = $this->loadChapter();
        $training = $this->loadTraining();
        if ($chapter !== null) {
            $model = new Clarification('create');
            if (isset($_POST['Clarification'])) {
                $model->attributes = $_POST['Clarification'];
                if ($model->validate()) {
                    $model->problem_id = $_POST['Clarification']['problem_id'];
                    $model->questioner_id = Yii::app()->user->getId();
                    $model->chapter_id = $chapter->id;
                    if ($model->save(false)) {
                        $this->redirect(array('training/' . $training->id  . '/chapter/' . $chapter->id . '#clarification'));
                    }
                }
            }
        }
    }

    /**
     * View Problem
     */
    public function actionViewProblem(){
        $training = $this->loadTraining();
        $chapter = $this->loadChapter();
        $problem = $this->loadProblem();

        if ($chapter->isAccessible(Yii::app()->user , $training) && $chapter->hasProblem($problem)) {
            $this->pageTitle = $chapter->name;

            $this->render('view_problem', array(
                'training' => $training,
                'chapter' => $chapter,
                'problem' => $problem
            ));
        }
        else if (!$chapter->isAccessible(Yii::app()->user , $training))
            throw new CHttpException (403, 'You are not allowed to open this chapter yet');
        else
            throw new CHttpException (404, 'The requested page doesn\'t exist');
    }

    
    public function actionViewSubmission(){
        $training = $this->loadTraining();
        $chapter = $this->loadChapter();
        $problem = $this->loadProblem();

        if ($chapter->isAccessible(Yii::app()->user , $training) && $chapter->hasProblem($problem)) {
            $this->pageTitle = $chapter->name;

            $submissionDataProvider = new CActiveDataProvider('Submission', array(
                'pagination' => array(
                    'pageSize' => 20,
                ),
                'criteria' => array(
                    'select' => array('id', 'submitted_time', 'grade_status' , 'verdict'),
                    'condition' => 'chapter_id = :chapter_id AND problem_id = :problem_id AND submitter_id = :submitter_id',
                    'params' => array(
                        'problem_id' => $problem->id,
                        'submitter_id' => Yii::app()->user->getId(),
                        'chapter_id' => $chapter->id
                    ),
                )
            ));

            $this->render('view_submission', array(
                'training' => $training,
                'chapter' => $chapter,
                'problem' => $problem,
                'submissionDataProvider' => $submissionDataProvider
            ));
        }
        else if (!$chapter->isAccessible(Yii::app()->user , $training))
            throw new CHttpException (403, 'You are not allowed to open this chapter yet');
        else
            throw new CHttpException (404, 'The requested page doesn\'t exist');
    }


    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Training::model()->findByPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        $this->trainingId = $this->_model->id;
        return $this->_model;
    }

    public function loadTraining(){
        if ($this->training === null){
            if (isset($_GET['id']))
                $this->training = Training::model()->findByPk($_GET['id']);
            if ($this->training === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            //TODO: if training is not open throw 404
        }
        return $this->training;
    }

    public function loadChapter($checkTraining = true){
        if ($this->chapter === null){
            if (isset($_GET['cid']))
                $this->chapter = Chapter::model()->findByPk($_GET['cid']);
            if ($this->chapter === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            //TODO: if chapter is not part of the training throw 404
            //TODO: if chapter is not open for the training throw 404
            //TODO: if user is not sufficient for the chapter throw 404
        }
        return $this->chapter;
    }

    public function loadProblem($checkTraining = true, $checkChapter = true){
        if ($this->problem === null){
            if (isset($_GET['pid']))
                $this->problem = Problem::model()->findByPk($_GET['pid']);
            if ($this->problem === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            //TODO: if problem is not part of the chapter throw 404
            //TODO: if problem is not open for the chapter throw 404
            //TODO: if user is not sufficient for the problem's chapter throw 404
        }
        return $this->problem;
    }
}
