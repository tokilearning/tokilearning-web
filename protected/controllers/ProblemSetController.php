<?php

/**
 *
 */
class ProblemSetController extends CMemberController {

    public $defaultAction = 'list';

    public function actionList() {
        $this->pageTitle = Yii::app()->name . " - ";
        $problemsetmenuitems = array();
        if (isset($_GET['id']) && $_GET['id'] != 0) {
            $problemset = ProblemSet::model()->published()->findByPk($_GET['id']);
            if (isset($problemset) && $problemset != null && $problemset->isPublished()) {
                $parent = $problemset;
                $this->pageTitle .= $parent->name;
                $problemsetmenuitems[] = array(
                    'label' => '...',
                    'url' => array('problemset/list', 'id' => $parent->parent->id),
                    'itemOptions' => array('class' => 'parent')
                );
                $problemsets = $problemset->children;
                $problems = $problemset->problems;
            } else {
                throw new CHttpException(404, 'Bundel Soal tidak ditemukan');
            }
        } else {
            $parent == null;
            $problemsets = ProblemSet::model()->root()->published()->findAll();
        }
        if (isset($problemsets) && $problemsets != null) {
            foreach ($problemsets as $p) {
                if ($p->isPublished()) {
                    $problemsetmenuitems[] = array(
                        'label' => $p->name,
                        'url' => array('problemset/list', 'id' => $p->id),
                        'itemOptions' => array('class' => 'problemset')
                    );
                }
            }
        }
        if (isset($problems) && $problems != null) {
            foreach ($problems as $problem) {
                if ($problem->visibility == Problem::VISIBILITY_PUBLIC){
                $problemsetmenuitems[] = array(
                        'label' => $problem->title,
                        'url' => array('problem/view', 'id' => $problem->id),
                        'itemOptions' => array('class' => 'problem')
                    );
                }
            }
        }

        $this->render('list', array(
            'problemsetmenuitems' => $problemsetmenuitems,
            'problemset' => $problemset
        ));
    }

}