<?php

/**
 *
 */
class HomeController extends CMemberController {

    public $pageTitle = 'Laman';
    public $needTitle = false;

    public function actionIndex() {
        $this->layout = 'application.views.layouts.column1l31r';
        $dataProvider = new CActiveDataProvider('Announcement', array(
                    'criteria' => array(
                        'condition' => 'status = :status',
                        'params' => array(
                            'status' => ContestNews::STATUS_PUBLISHED,
                        ),
                        'with' => array('author'),
                    ),
                    'pagination' => array(
                        'pageSize' => 4,
                    ),
                ));
        $this->render('index',
                array(
                    'dataProvider' => $dataProvider
                )
        );
    }


    public function actionGetLastPendingSubmission() {
        $submission = Submission::getFirstPending();

        if ($submission === null) {
            $retval = array();
            $retval['submission'] = $submission->getAttributes();
            $retval['problem'] = $submission->problem->getAttributes();

            echo json_encode($retval);
        }
        else
            echo "0";
    }

}