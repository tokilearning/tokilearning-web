<?php

class ChapterController extends CSupervisorController {

    private $_model;
    public $pageTitle = "Bab Latihan";

    /**
     *
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Chapter', array(
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function getChapter() {
        return $this->_model;
    }

    /**
     *
     */
    public function actionView() {
        $model = $this->loadModel();
        $criteria = new CDbCriteria;
        $criteria->condition = 'chapter_id = '.$model->id;
        $criteria->select = array('id', 'submitted_time', 'problem_id', 'grade_time', 'grade_status', 'verdict' , 'score');
        $criteria->with = array(
                            'problem' => array('select' => array('id', 'title')),
                            'submitter' => array('select' => array('id', 'username' , 'full_name'))
                        );
        if (isset($_GET['filterproblem'])){
            if (($pid = $_GET['filterproblem']) != 'all') {
                $criteria->addCondition('problem_id = '.$pid);
            }
        }
        if (isset($_GET['filtercontestant'])){
            if (($uid = $_GET['filtercontestant']) != 'all'){
                $criteria->addCondition('submitter_id = '.$uid);
            }
        }
        $dataProvider = new CActiveDataProvider('Submission', array(
            'pagination' => array(
                        'pageSize' => 20,
                    ),
            'criteria' => $criteria
        ));

        $participantDataProvider = new CActiveDataProvider('User', array(
                'pagination' => array(
                    'pageSize' => 20,
                ),
                'criteria' => array(
                    'join' => 'JOIN chapters_users ON user_id = id',
                    'condition' => 'chapter_id = ' . $model->id
                )
            ));
        $problems = new CActiveDataProvider('Problem', array(
                'pagination' => array(
                    'pageSize' => 20,
                ),
                'criteria' => array(
                    'join' => 'JOIN chapters_problems ON problem_id = id',
                    'condition' => 'chapter_id = ' . $model->id
                )
            ));
        $clarificationDataProvider = new CArrayDataProvider($model->clarifications , array(
            'pagination' => array('pageSize' => 20)
        ));

        $this->pageTitle = $model->name;
        $this->render('view', array('model' => $model ,
            'clarificationDataProvider' => $clarificationDataProvider,
            'problems' => $problems , 'dataProvider' => $dataProvider , 'participantDP' => $participantDataProvider));
    }


    public function actionAnswer($id) {
        $model = Clarification::model()->findByPK($id);
        $model->setScenario('answer');
        if ($model !== null) {
            $model->attributes = $_POST['Clarification'];
            if ($model->validate()){
                $model->answered_time = new CDbExpression('NOW()');
                $model->status = Clarification::STATUS_ANSWERED;
                $model->answerer_id = Yii::app()->user->getId();
                $model->save(false);
                $this->redirect(array('supervisor/chapter/view/id/' . $model->chapter_id . '#clarifications'));
            }
        }
    }
	
	public function actionQuickRegrade($id) {
		echo $id;
	
        if (isset($_POST)) {
            $c = new CDbCriteria;
            $cid = $id;
            $c->condition = "chapter_id = $cid";
            $submissions = Submission::model()->findAll($c);

            $submitter_id = $_POST['submitter_id'];
            $problem_id = $_POST['problem_id'];

            foreach ($submissions as $submission) {
                //echo $this->getContest()->getProblemByAlias($submission->problem_id);
                if (($submission->submitter_id == $submitter_id || $submitter_id == 'all') && ($problem_id == $submission->problem_id || $problem_id == 'all')) {
                    $submission->setGradeStatus(Submission::GRADE_STATUS_PENDING);
                    $submission->save(false);
                }
            }
			
			echo "OK\n";
        }
    }

    public function actionDeleteClarification($id) {
        $model = Clarification::model()->findByPK($id);
        if ($model !== null) {
            $model->delete();
            $this->redirect(array('supervisor/chapter/view/id/' . $model->chapter_id . '#clarifications'));
        }
    }

    /**
     *
     */
    public function actionUpdate() {
        $model = $this->loadModel();
        $model->setScenario('update');
        if (isset($_POST['Chapter'])) {
            $model->setAttributes($_POST['Chapter']);
            if ($model->validate()) {
                $model->save(false);
                $this->redirect(array('supervisor/chapter/view/id/' . $model->id));
            }
        }

        $subchapters = $model->getSubChapters();
        /*$arsubchapters = array();
        foreach ($subchapters as $chapter) {
            $arsubchapters[] = $chapter;
        }*/

        $subchaptersDataProvider = new CArrayDataProvider($subchapters, array(
            'id' => 'id'
        ));

        $problemsDataProvider = new CActiveDataProvider('Problem', array(
            'pagination' => array(
                'pageSize' => 10,
            ),
            'criteria' => array(
                'join' => 'JOIN chapters_problems ON problem_id = id',
                'condition' => 'chapter_id = ' . $model->id,
            )
        ));
        $this->render('update', array('subchapters' => $subchaptersDataProvider , 'model' => $model , 'problemsDataProvider' => $problemsDataProvider , 'currtab' => $_GET['currtab']));
    }

    /**
     *
     */
    public function actionDelete() {
        //ajax
        if (Yii::app()->request->isAjaxRequest && isset($_GET['id']) && isset($_GET['modelid'])) {
            $model = $this->loadModel();
            $chapter = Chapter::model()->findByPK($_GET['modelid']);

            $model->setScenario('update');
            $next_chapter_id = $model->next_chapter_id;

            if ($model->previousChapter === NULL) {
                $chapter->setScenario('update');
                $chapter->first_subchapter_id = $next_chapter_id;
                $chapter->save(false);
            }
            else {
                $prevchap = $model->previousChapter;
                $prevchap->setScenario('update');
                $prevchap->next_chapter_id = $next_chapter_id;
                $prevchap->save(false);
            }

            $model->next_chapter_id = NULL;
            $model->save(false);
        }
    }

    /**
     *
     */
    public function actionCreate() {
        $model = new Chapter('create');
        if (isset($_POST['Chapter'])) {
            $model->setAttributes($_POST['Chapter']);
            if ($model->validate()){
                $model->save(false);
                $this->redirect(array('index'));
            }
        }
        $this->render('create', array('model' => $model));
    }


    public function actionResetParticipants() {
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest){
            if (isset($_POST['mark'])){
                $chapter = Chapter::model()->findByPK($_POST['Chapter']['id']);
                foreach($_POST['mark'] as $userid){
                    $user = User::model()->findByPK($userid);
                    $chapter->reset($user);
                }
            }
        }
        else if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['id'])) {
                $chapter = Chapter::model()->findByPK($_GET['id']);
                foreach($chapter->participants as $user){
                    $chapter->setCompletionRecursive($user , Chapter::CHAPTER_PARTICIPANT_WORKING);
                    $chapter->reset($user);
                }
            }
        }
    }

    //

    public function actionAddProblem() {
        //ajax
        if (Yii::app()->request->isAjaxRequest && isset($_GET['id']) && isset($_GET['problemid'])) {
            $model = $this->loadModel();
            $problem = Problem::model()->findByPk($_GET['problemid']);
            if ($problem != null){
                $model->addProblem($problem);
            }
        }
    }

    public function actionRemoveProblem() {
        //ajax
        if (Yii::app()->request->isPostRequest && isset($_GET['id']) && isset($_GET['problemid'])) {
            $model = $this->loadModel();
            $problem = Problem::model()->findByPk($_GET['problemid']);
            if ($problem != null){
                $model->removeProblem($problem);
                if (!isset($_GET['ajax']))
                    $this->redirect(array('index'));
            }
        }
    }


    public function getModel() {
        return $this->_model;
    }


    public function actionDecreaseOrder() {
        if (isset($_GET['id']) && isset($_GET['modelid'])) {
            $model = $this->loadModel();

            if ($model != null) {
                $model->setScenario('update');
                $prevChapter = $model->previousChapter;
                if ($prevChapter !== NULL) {
                    $prevChapter->setScenario('update');

                    if ($prevChapter->parentChapter !== NULL) {
                        $parentChapter = $prevChapter->parentChapter;
                        $parentChapter->setScenario('update');

                        $prevChapter->next_chapter_id = $model->next_chapter_id;
                        $model->next_chapter_id = $prevChapter->id;
                        $parentChapter->first_subchapter_id = $model->id;
                        $parentChapter->save(false);
                    }
                    else {
                        $prevprevChap = $prevChapter->previousChapter;
                        $prevprevChap->setScenario('update');

                        $prevChapter->next_chapter_id = $model->next_chapter_id;
                        $model->next_chapter_id = $prevChapter->id;
                        $prevprevChap->next_chapter_id = $model->id;
                        $prevprevChap->save(false);
                    }
                    $prevChapter->save(false);
                }
                $model->save(false);
            }
            if (!isset($_GET['ajax']))
                $this->redirect(Yii::app()->controller->createUrl('supervisor/chapter/update/id/'.$_GET['modelid'].'?currtab=subbab'));
        }
    }


    public function actionIncreaseOrder() {
        
    }
    

    public function actionAddSubChapter() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
            $chapter = Chapter::model()->findByPK($_GET['id']);
            $subchapter = Chapter::model()->findByPK($_GET['subchapterid']);

            if ($chapter == NULL || $subchapter == NULL) return;

            if ($chapter->id == $subchapter->id) return;

            $chap = $chapter->firstSubChapter;

            if ($chap === NULL) {
                $chapter->setScenario('update');
                $chapter->first_subchapter_id = $subchapter->id;
                $chapter->save(false);
            }
            else {
                while ($chap->nextChapter !== NUll) {
                    $chap = $chap->nextChapter;
                }
                $chap->setScenario('update');
                $chap->next_chapter_id = $subchapter->id;
                $chap->save(false);
            }
        }
    }

    public function actionAddParticipant(){
        /*if (Yii::app()->request->isAjaxRequest && isset($_GET['userid'])){
            $user = User::model()->findByPk($_GET['userid']);
            $chapter = Chapter::model()->findByPk($_GET['chapterid']);
            if ($user != null) {
                $chap1 = $chapter->previousChapter;
                $chapter->openBy($user);
                $chapter->setCompletion($user , Chapter::CHAPTER_PARTICIPANT_WORKING);

                while ($chap1 !== NULL) {
                    $chap1->openBy($user);
                    $chap1->setCompletion($user , Chapter::CHAPTER_PARTICIPANT_COMPLETE);
                    $chap1 = $chap1->previousChapter;
                }

                $chap2 = $chapter->getParentChapter();
                while ($chap2 != NULL) {
                    $chap1 = $chap2->previousChapter;
                    $chap2->openBy($user);
                    $chap2->setCompletion($user , Chapter::CHAPTER_PARTICIPANT_WORKING);
                    while ($chap1 != NULL) {
                        $chap1->openBy($user);
                        $chap1->setCompletion($user , Chapter::CHAPTER_PARTICIPANT_COMPLETE);
                        $chap1 = $chap1->previousChapter;
                    }
                    $chap2 = $chap2->getParentChapter();
                }
            }
        }*/
    }

    //
    /**
     *
     */
    public function actionPublish() {
        //ajax
    }

    public function actionUnpublish() {
        //ajax
    }

    public function actionChapterLookup() {
        //ajax
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
            $name = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->condition = "name LIKE :sterm";
            $criteria->params = array(":sterm" => "%$name%");
            $chapters = Chapter::model()->findAll($criteria);
            $retval = array();
            foreach ($chapters as $chapter) {
                $retval[] = array(
                    'value' => $chapter->getAttribute('id'),
                    'label' => $chapter->getAttribute('id') . '. ' . $chapter->getAttribute('name')
                );
            }
            echo CJSON::encode($retval);
        }
    }

    public function actionOrphanChapterLookup() {
        //ajax
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
            $name = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->condition = "name LIKE :sterm";
            $criteria->params = array(":sterm" => "%$name%");
            $chapters = Chapter::model()->findAll($criteria);
            $retval = array();
            foreach ($chapters as $chapter) {
                if ($chapter->nextChapter === NULL && $chapter->previousChapter === NULL && $_GET['modelid'] != $chapter->id && $chapter->training === NULL && $chapter->parentChapter === NULL) {
                    $retval[] = array(
                        'value' => $chapter->getAttribute('id'),
                        'label' => $chapter->getAttribute('id') . '. ' . $chapter->getAttribute('name')
                    );
                }
            }
            echo CJSON::encode($retval);
        }
    }

    public function actionProblemLookup() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $title = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->condition = "title LIKE :sterm";
            $criteria->params = array(":sterm" => "%$title%");
            $problems = Problem::model()->findAll($criteria);
            $retval = array();
            foreach ($problems as $problem) {
                $retval[] = array(
                    'value' => $problem->getAttribute('id'),
                    'label' => $problem->getAttribute('id') . '. ' . $problem->getAttribute('title')
                );
            }
            echo CJSON::encode($retval);
        }
    }

    public function actionUserLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $query = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->condition = "(id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm)";
            $criteria->params = array(
                ":sterm" => "%$query%"
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

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Chapter::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}
