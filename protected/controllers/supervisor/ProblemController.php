<?php

class ProblemController extends CSupervisorController {

    private $_model;
    
    public function actionIndex() {
        $criteria = new CDbCriteria;
        $filter = 'all';
        if (isset($_GET['filter'])){
            $filter = $_GET['filter'];
        }
        switch($filter){
            case 'mine' :
                $criteria->addCondition('author_id = '.Yii::app()->user->getId());
                break;
            case 'all' :
            default:
                break;
        }
        //NOTE: Optimize SQL
        $criteria->with = array('author' => array('select' => 'id, full_name'));
        $dataProvider = new CActiveDataProvider('Problem', array(
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                    'criteria' => $criteria,
                ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionCreate() {
        $model = new Problem('create');
        if (isset($_POST['Problem'])){
            $model->attributes = $_POST['Problem'];
            $model->visibility = Problem::VISIBILITY_DRAFT;
            if ($model->validate()){
                $model->author_id = Yii::app()->user->getId();
                $model->save(false);
                $this->redirect(array('update', 'id' => $model->id));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionDelete() {
        $model = $this->loadModel();
        $model->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        $activeTab = $_GET['return'];
        $evalActiveTab = $_GET['ereturn'];
        $this->render('update', array('model' => $model, 'activeTab' => $activeTab, 'evalActiveTab' => $evalActiveTab));
    }

    public function actionUpdateInformation(){
        $model = $this->loadModel();
        if (isset($_POST['Problem'])){
            $model->attributes = $_POST['Problem'];
            if ($model->save()){
                $this->redirect(array('update', 'id' => $model->id));
            }
        }
        $this->render('update', array('model' => $model));
    }

    public function actionUpdateConfigurationForm(){
        if (Yii::app()->request->isPostRequest){
            $model = $this->loadModel();
            $config = $_POST['config'];
            ProblemHelper::updateConfig($model, $config);
            $this->redirect(array('update', 'id' => $model->id, 'return' => 'evaluator', 'ereturn' => 'form'));
        } else {
            throw new CHttpException(400, "Bad Request");
        }
    }

    public function actionUpdateConfigurationManual(){
        if (Yii::app()->request->isPostRequest){
            $model = $this->loadModel();
            $configs = CJSON::decode($_POST['json_content']);
            $model->setConfigs($configs);
            $model->save();
            $this->redirect(array('update', 'id' => $model->id, 'return' => 'evaluator', 'ereturn' => 'manual'));
        } else {
            throw new CHttpException(400, "Bad Request");
        }
    }

    public function actionUpdateDescriptionFile(){
        if (Yii::app()->request->isPostRequest){
            $model = $this->loadModel();
            ProblemHelper::updateDescription($model, $_POST['descriptionfile']);
            $model->save();
            $this->redirect(array('update', 'id' => $model->id, 'return' => 'display'));
        } else {
            throw new CHttpException(400, "Bad Request");
        }
    }

    public function actionGetEvaluatorFile(){
        $model = $this->loadModel();
        $filename = $_GET['file'];
        $dirpath = $model->getEvaluatorPath();
        $filepath = $dirpath."files/".basename($filename);
        if (file_exists($filepath)){
            header('Content-type: '.CFileHelper::getMimeType($filename));
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            readfile($filepath);
            exit;
        } else {
            throw new CHttpException(404, "File not found");
        }
    }

    public function actionUploadEvaluatorFile(){
        if (Yii::app()->request->isPostRequest){
            $model = $this->loadModel();
            $uploads_dir = $model->getEvaluatorPath().'files';
            foreach ($_FILES["evaluatorfileupload"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["evaluatorfileupload"]["tmp_name"][$key];
                    $name = $_FILES["evaluatorfileupload"]["name"][$key];
                    move_uploaded_file($tmp_name, "$uploads_dir/$name");
                }
            }
            $model->save();
            $this->redirect(array('update', 'id' => $model->id, 'return' => 'evaluator'));
        } else {
            throw new CHttpException(400, "Bad Request");
        }
    }

    public function actionDeleteEvaluatorFile(){
        $model = $this->loadModel();
        $file = $_GET['file'];
        $model->deleteEvaluatorFile($file);
        $model->save();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionGetViewFile(){
        $model = $this->loadModel();
        $filename = $_GET['file'];
        $dirpath = $model->getViewPath();
        $filepath = $dirpath."files/".basename($filename);
        if (file_exists($filepath)){
            header('Content-type: '.CFileHelper::getMimeType($filename));
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            readfile($filepath);
            exit;
        } else {
            throw new CHttpException(404, "File not found");
        }
    }

    public function actionUploadViewFile(){
        if (Yii::app()->request->isPostRequest){
            $model = $this->loadModel();
            $uploads_dir = $model->getViewPath().'files';
            foreach ($_FILES["viewfileupload"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["viewfileupload"]["tmp_name"][$key];
                    $name = $_FILES["viewfileupload"]["name"][$key];
                    move_uploaded_file($tmp_name, "$uploads_dir/$name");
                }
            }
            $model->save();
            $this->redirect(array('update', 'id' => $model->id, 'return' => 'display'));
        } else {
            throw new CHttpException(400, "Bad Request");
        }
    }

    public function actionDeleteViewFile(){
        $model = $this->loadModel();
        $file = $_GET['file'];
        $model->deleteViewFile($file);
        $model->save();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionPublish(){
        $model = $this->loadModel();
        $model->visibility = Problem::VISIBILITY_PUBLIC;
        $model->save();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionUnpublish(){
        $model = $this->loadModel();
        $model->visibility = Problem::VISIBILITY_DRAFT;
        $model->save();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }


    public function actionView() {
        $model = $this->loadModel();
        if (isset($_GET['view']) && $_GET['view'] == 'full'){
            $this->layout = 'application.views.layouts.column1';
            $this->render('view/_problem2', array('model' =>  $model));
        } else {
            $submissionDataProvider = new CActiveDataProvider('Submission', array(
                'pagination' => array(
                    'pageSize' => 20,
                ),
                'criteria' => array(
                    'select' => array('id', 'submitted_time', 'grade_status'),
                    'condition' => 'contest_id IS NULL AND problem_id = :problem_id',
                    'params' => array(
                        'problem_id' => $model->id
                    ),
                    'with' => array(
                            'problem' => array('select' => array('id', 'title')),
                            'problem.problemtype' => array('select' => array('id', 'name')),
                            'submitter' => array('select' => array('id', 'full_name'))
                    )
                )
            ));

            $activeTab = $_GET['return'];
            $this->render('view', array(
                    'model' =>  $model,
                    'activeTab' => $activeTab,
                    'submissionDataProvider' => $submissionDataProvider
                ));
        }
    }

    public function actionSubmitAnswer(){
        $model = $this->loadModel();
        if (Yii::app()->request->isPostRequest){
            if (!isset($_POST['Submission']['id'])){
                $submission = new Submission();
                $submission->submitter_id = Yii::app()->user->getId();
                $submission->problem_id = $model->id;
                $submission->contest_id = NULL;
                $submission->grade_status = Submission::GRADE_STATUS_PENDING;
                try {
                    ProblemHelper::submitAnswer($submission);
                    $submission->save();
                    $this->redirect(array('view', 'id' => $model->id, 'return' => 'submission'));
                } catch (Exception $ex) {
                    $submission->addError('answer', $ex->getMessage());
                    $this->render('view',
                            array(
                                'model' =>  $model,
                                'activeTab' => 'submit',
                                'submission' => $submission
                            )
                    );
                }
            } else {
                //TODO
            }
        } else {
            throw new CHttpException(400, "Bad request");
        }
    }

    public function actionRegrade(){
        $model = $this->loadModel();
        if (isset($_GET['problemid']))
            //TODO select id and grade_status only
            $submission = Submission::model()->findbyPk($_GET['problemid']);
        if ($submission !== null){
            $submission->setGradeStatus(Submission::GRADE_STATUS_PENDING);
            $submission->save(false);
            $this->redirect(array('view', 'id' => $model->id, 'return' => 'submission'));
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Problem::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }
}
