<?php


class TrainingController extends CSupervisorController {

    private $_model;
    public $pageTitle = "Latihan";

    /**
     * 
     */
    public function actionIndex(){
        $dataProvider = new CActiveDataProvider('Training', array(
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));

        $this->render('index' , array('dataProvider' => $dataProvider));
    }

    /**
     * 
     */
    public function actionView(){
        $model = $this->loadModel();
        $this->pageTitle = $model->name;
        $chapters = $model->getChapters();

        foreach ($chapters as $chap) {
            //echo $chap->name . " " . $chap->previousChapter->name . " " . $chap->training->name . "<br />";
            //echo $chap->id . " " . $chap->getRequiredChapter()->id . "<br />";
            //echo $chap->name . " " . $chap->isAccessible(Yii::app()->user , $model->id) . "<br />";
        }

        if ($_GET['section'] === "participants") {
            $this->pageTitle = $model->name . " - Peserta";
            $this->render('viewparticipants' , array('model' => $model));
        }
        else {
            $this->pageTitle = $model->name . " - Index";
            $this->render('view' , array('model' => $model , 'chapters' => $chapters));
        }
    }

    /**
     * Generate user report on a training
     */
    public function actionGenerateReport() {
        if (isset($_GET['userid'])) {
            $model = $this->loadModel();
            $user = User::model()->findByPK($_GET['userid']);

            $result = array();
            self::getTrainingReport($model->first_chapter, $user, $result);

            $arresult = array();
            ///Make it dataprovider
            foreach ($result as $id => $element) {
                $data = array();
                for ($i = 1 ; $i <= $element['level'] ; $i++) {
					if ($i == $element['level'])
						$data['name'] .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					else
						$data['name'] .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}

				$chapter = Chapter::model()->findByPK($id);

				if ($chapter->isCompleted($user)) {
					$data['name'] .= '<a style="color: #05F505; font-weight: bold; text-decoration: none;" href="'.$this->createUrl('supervisor/chapter/view' , array('id' => $chapter->id)).'">' . $chapter->name . '</a>';
				}
				else {
					$data['name'] .= '<a style="color: #F50505; font-weight: bold; text-decoration: none;" href="'.$this->createUrl('supervisor/chapter/view' , array('id' => $chapter->id)).'">' . $chapter->name . '</a>';
				}
                
                $data['finishtime'] = $element['finishtime'] / 3600 . " jam";
                $data['completed'] = $element['completed'];
                $data['details'] = "";

                //if (count($element['problemstatus']) > 0)
                foreach ($element['problemstatus'] as $problemid => $problemStatus) {
                    $problem = Problem::model()->findByPK($problemid);
                    $data['details'] .= "<a href='".$this->createUrl('supervisor/problem/view' , array('id' => $problem->id))."' >".$problem->title."</a>" . ": ". $problemStatus['success'] . "/" . $problemStatus['trial'] . "<br />";
                }

                $arresult[] = $data;
            }

            //print_r($data);

            $dataProvider = new CArrayDataProvider($arresult, array(
				'pagination' => array(
                    'pageSize' => 100,
                ),
			));

            echo "<h3>Report untuk ". $user->full_name ."</h3>";
            $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider' => $dataProvider,
                'columns' => array(
                    'name' => array(
                        'type' => 'raw',
                        'name' => 'Bab',
                        'value' => '$data["name"]'
                    ),
                    'finishtime' => array(
                        'type' => 'raw',
                        'name' => 'Durasi Penyelesaian',
                        'value' => '$data["finishtime"]'
                    ),
                    'details' => array(
                        'type' => 'raw',
                        'name' => 'Rincian (Soal: Success/Trial)',
                        'value' => '$data["details"]'
                    ),
                ),
                'enablePagination' => false,
                'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
                'id' => 'subchaptergridview'
            ));
        }
    }

    /**
     * Iterate sub-chapters recursively, appended to array $result
     * @param <type> $pChapter
     */
    private static function getTrainingReport($pChapter , $pUser , &$result , $level = 0) {
        $tresult = $pChapter->getReport($pUser);
        $tresult['level'] = $level;

        $result[$pChapter->id] = $tresult;

        foreach ($pChapter->getSubChapters() as $subChapter) {
            self::getTrainingReport($subChapter , $pUser , $result , $level + 1);
        }
    }

    /**
     * 
     */
    public function actionDelete() {
        $model = $this->loadModel();
        $model->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        $model->setScenario('update');
        if (isset($_POST['Training'])) {
            $model->setAttributes($_POST['Training']);
            if ($model->validate()) {
                $model->save(false);
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('update' , array('model' => $model));
    }

    /**
     * 
     */
    public function actionCreate() {
        $model = new Training('create');

        if (isset($_POST['Training'])) {
            $model->creator_id = Yii::app()->user->id;
            $model->setAttributes($_POST['Training']);
            if ($model->validate()) {
                $model->save(false);
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }

    //

    public function actionAddChapter(){
        //ajax
    }

    public function actionRemoveChapter(){
        //ajax
    }

    //
    /**
     * 
     */
    public function actionPublish(){
        //ajax
    }

    public function actionUnpublish(){
        //ajax
    }

    //
    public function actionChapterLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])){
            $title = $_GET['term'];
            $criteria = new CDbCriteria;
            $criteria->condition = "name LIKE :sterm";
            $criteria->params = array(":sterm" => "%$title%");
            $problems = Chapter::model()->findAll($criteria);
            $retval = array();
            foreach ($problems as $problem) {
                if ($chapter->nextChapter === NULL && $chapter->previousChapter === NULL && $chapter->training === NULL) {
                    $retval[] = array(
                        'value' => $problem->getAttribute('id'),
                        'label' => $problem->getAttribute('id') . '. ' . $problem->getAttribute('name'),
                    );
                }
            }
            echo CJSON::encode($retval);
        }
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Training::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }
}