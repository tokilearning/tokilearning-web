<?php

class NewsController extends CContestController {

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ContestNews', array(
            'criteria'=>array(
                'condition' => 'status = :status AND contest_id = :contestid',
                'params'=>array(
                    'status' => ContestNews::STATUS_PUBLISHED,
                    'contestid' => $this->getContest()->id
                ),
                'with'=>array('author'),
            ),
            'pagination'=>array(
                'pageSize'=>20,
            ),
        ));
        $this->render('index',
                array(
                    'dataProvider' => $dataProvider
                )
        );
    }

    public function actionView() {
        $this->render('view');
    }

}
