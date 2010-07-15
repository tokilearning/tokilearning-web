<?php

/**
 *
 */
class AnnouncementController extends CMemberController {

    public $defaultAction = 'view';

    public function actionView() {
        if (isset($_GET['id'])) {
            $announcement = Announcement::model()->findByPk($_GET['id']);
            if ($announcement != null) {
                $this->setPageTitle($announcement->title);
                $this->render('view', array('post' => $announcement));
            } else {
                throw new CHttpException(404, 'Berita tidak dapat ditemukan');
            }
        } else {
            throw new CHttpException(404, 'Berita tidak dapat ditemukan');
        }
    }

    public function actionList() {
        //$announcements = Announcement::model()->findAll();
        $dataProvider = new CActiveDataProvider('Announcement', array(
                ));
        $this->render('list', array('dataProvider' => $dataProvider));
    }

}