<?php
class ProblemtypesController extends CSupervisorController {

    private $_model;
    public $pageTitle = "Tipe Soal";
    
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ProblemType', array(
                    'pagination' => array(
                        'pageSize' => 10,
                    ),
                ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionView() {
        $this->render('view');
    }

    public function actionCreate() {
        $this->render('create');
    }

    public function actionUpdate() {
        $this->render('update');
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = ProblemType::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }
}
