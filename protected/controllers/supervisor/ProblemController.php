<?php

Yii::import('ext.language.LanguageFactory');

class ProblemController extends CSupervisorController {

    //public $pageTitle = "Soal";
    private $_model;
    private $categories = array(
            "Dynamic Programming",
            "Graph",
            "Tree",
            "Ad hoc"
        );

    public function actionIndex() {
        /*$problems = Problem::model()->findAll();

        foreach ($problems as $p) {
            $dir =  $p->getDirectoryPath() . 'evaluator/files';
            //echo $dir . "<br />";
            echo exec("dos2unix $dir/*");
        }*/

        $criteria = new CDbCriteria;
        $filter = 'all';
        /*if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
            switch ($filter) {
                case 'mine' :
                    $criteria->addCondition('author_id = ' . Yii::app()->user->getId());
                    break;
                case 'all' :
                default:
                    break;
            }
        }*/
        $filter = $_GET['filter'];
        switch ($filter) {
            case 'mine' :
                $criteria->addCondition('author_id = ' . Yii::app()->user->getId());
                break;
            case 'privileged' :
                $criteria->join = "LEFT JOIN problem_privileges ON problem_id = id";
                //$criteria->addCondition('author_id = ' . Yii::app()->user->getId());
                $criteria->addCondition('user_id = ' . Yii::app()->user->getId() , 'OR');
                break;
            case 'all' :
            default:
                break;
        }

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            
            $searchElements = explode(" ", $search);
            foreach ($searchElements as $elm) {
                $criteria->addSearchCondition('title', $elm);
                $criteria->addSearchCondition('description', $elm, true, 'OR');
            }
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
        if (isset($_POST['Problem'])) {
            $model->attributes = $_POST['Problem'];
            $model->visibility = Problem::VISIBILITY_DRAFT;
            if ($model->validate()) {
                $model->author_id = Yii::app()->user->getId();
                $model->save(false);
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $f = new LanguageFactory();
        $availableLanguages = $f->getSupportedLanguages();

        $this->render('create', array('model' => $model , 'availableLanguages' => $availableLanguages));
    }
    
    public function actionCategoryLookup($term) {
        $retval = array();
        
        if(Yii::app()->request->isAjaxRequest && !empty($term)) {
            foreach ($this->categories as $cat) {
                if (strpos($cat , $term) !== false) {
                    $retval[] = $cat;
                }
            }
        }
        
        echo CJSON::encode($retval);
    }

    public function actionDelete() {
        $model = $this->loadModel();
        $model->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        if (isset($_POST['Problem'])) {
            $model->attributes = $_POST['Problem'];
            $model->description = $_POST['category'] . "\n" . $_POST['difficulty'];
            if ($model->save()) {
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $f = new LanguageFactory();
        $availableLanguages = $f->getSupportedLanguages();
        
        $this->render('update', array('model' => $model , 'availableLanguages' => $availableLanguages));
    }

    public function actionConfigure() {
        $model = $this->loadModel();
        $this->render('configure', array('model' => $model));
    }

    public function actionGrantPrivilege() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
            $model = Problem::model()->findByPK($_GET['id']);

            $model->grantPrivilege(User::model()->findByPK($_GET['userid']));
        }
    }

    public function actionSupervisorLookup() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $query = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->join = "JOIN groups_users ON user_id = id";
            $criteria->condition = "(id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm) AND group_id = :groupid AND id <> " . Yii::app()->user->id;
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

    public function actionRevokePrivilege() {
        $model = $this->loadModel();

        $model->revokePrivilege(User::model()->findByPK($_GET['userid']));
    }

    public function actionPrivilege() {
        $model = $this->loadModel();

        $dataProvider = new CArrayDataProvider($model->privileged_users, array(
            'pagination' => array(
                'pageSize' => 20
            )
        ));
        
        $this->render('privilege' , array('model' => $model , 'dataProvider' => $dataProvider));
    }

    public function actionArena() {
        $model = $this->loadModel();

        $dataProvider = new CArrayDataProvider($model->arenas, array(
            'pagination' => array(
                'pageSize' => 20
            )
        ));

        $this->render('arena' , array('model' => $model , 'dataProvider' => $dataProvider));
    }

    public function actionAddArena() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
            $model = $this->loadModel();

            $model->addArena(Arena::model()->findByPK($_GET['arenaid']));
        }
    }

    public function actionRemoveArena() {
        $model = $this->loadModel();

        $model->removeArena(Arena::model()->findByPK($_GET['arenaid']));
    }

    public function actionArenaLookup() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $query = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->condition = "name LIKE :sterm";
            $criteria->params = array(
                ":sterm" => "%$query%"
            );
            $arenas = Arena::model()->findAll($criteria);
            $retval = array();
            foreach($arenas as $arena)
            {
                $retval[] = array(
                    'value' => $arena->getAttribute('id'),
                    'label' => $arena->getAttribute('id').'. '.$arena->getAttribute('name')
                );
            }
            echo CJSON::encode($retval);
        }
    }

    public function actionPublish() {
        $model = $this->loadModel();
        $model->visibility = Problem::VISIBILITY_PUBLIC;
        $model->save();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionUnpublish() {
        $model = $this->loadModel();
        $model->visibility = Problem::VISIBILITY_DRAFT;
        $model->save();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionRegrade() {
        $model = $this->loadModel();
        if (isset($_GET['submissionid']))
            $submission = Submission::model()->findbyPk($_GET['submissionid']);
        //
        if ($submission !== null) {
            $submission->setGradeStatus(Submission::GRADE_STATUS_PENDING);
            $submission->save(false);
            $this->redirect(array('submissions', 'id' => $model->id));
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    //
    public function actionView() {
        $model = $this->loadModel();
        $this->render('view', array('model' => $model));
    }

    public function actionDownload() {
        $model = $this->loadModel();
        $id = $model->id;
        $tempnam = tempnam("/tmp", "p$id");
        if (Zip::createZip($model->getDirectoryPath(), $tempnam)) {
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="' . $id . '.zip"');
            readfile($tempnam);
            unlink($tempnam);
        }
        exit();
    }

    public function actionSubmissions() {
        $model = $this->loadModel();
        $submissionDataProvider = new CActiveDataProvider('Submission', array(
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                    'criteria' => array(
                        'select' => array('id', 'submitted_time', 'grade_status', 'score', 'verdict'),
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
        $this->render('submissions', array(
            'model' => $model,
            'submissionDataProvider' => $submissionDataProvider,
        ));
    }

    public function actionBatchRegrade() {
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {
            if (isset($_POST['mark'])) {
                foreach ($_POST['mark'] as $regradeid) {
                    $model = Submission::model()->findbyPk($regradeid);
                    if ($model !== null) {
                        $model->setGradeStatus(Submission::GRADE_STATUS_PENDING);
                        $model->save(false);
                    }
                }
            }
        }
    }

    public function actionBatchSkip() {
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {
            if (isset($_POST['mark'])) {
                foreach ($_POST['mark'] as $regradeid) {
                    $model = Submission::model()->findbyPk($regradeid);
                    if ($model !== null) {
                        $model->setGradeStatus(Submission::GRADE_STATUS_NOGRADE);
                        $model->save(false);
                    }
                }
            }
        }
    }

    //

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Problem::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            else {
                if (!$this->_model->isPrivileged(Yii::app()->user)) {
                        throw new CHttpException(404, 'You are not allowed to access this resource');
                }
            }
        }
        return $this->_model;
    }

}
