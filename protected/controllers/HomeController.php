<?php

/**
 *
 */
class HomeController extends CMemberController {

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Announcement', array(
            'criteria'=>array(
                'condition' => 'status = :status',
                'params'=>array(
                    'status' => ContestNews::STATUS_PUBLISHED,
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
}