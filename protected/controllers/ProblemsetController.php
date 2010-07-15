<?php

/**
 *
 */
class ProblemsetController extends CMemberController {

    public $defaultAction = 'list';

    public function accessRules() {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('list'),
                'users' => array('*'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function init() {
        parent::init();
        if (Yii::app()->user->isGuest) {
            $this->layout = 'application.views.layouts.static';
        }
    }

    public function actionList() {
        $this->pageTitle = Yii::app()->name . " - ";
        $problemsetitems = array();
        $i = 0;
        if (isset($_GET['id']) && $_GET['id'] != 0) {
            $problemset = ProblemSet::model()->published()->findByPk($_GET['id']);
            if (isset($problemset) && $problemset != null && $problemset->isPublished()) {
                $parent = $problemset;
                $this->pageTitle .= $parent->name;
                $problemsetitems[] = array(
                    'rank' => $i++,
                    'title' => '...',
                    'url' => array('problemset/list', 'id' => $parent->parent->id),
                    'type' => 'parent',
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
                    $problemsetitems[] = array(
                        'rank' => $i++,
                        'title' => $p->name,
                        'url' => array('problemset/list', 'id' => $p->id),
                        'type' => 'problemset'
                    );
                }
            }
        }
        //$statistics = StatisticsHandler::instance();
        if (isset($problems) && $problems != null) {
            foreach ($problems as $problem) {
                if ($problem->visibility == Problem::VISIBILITY_PUBLIC) {
                    $item = array(
                        'rank' => $i++,
                        'title' => $problem->title,
                        'url' => array('problem/view', 'id' => $problem->id),
                        'type' => 'problem',
                    );
                    $problemstat = $statistics->getProblemStat();
                    $userstat = $statistics->getUserStat();
                    $stats = array();
                    if (isset($problemstat['problems']) && isset($problemstat['problems'][$problem->id])) {
                        $pidstat = $problemstat['problems'][$problem->id];
                        $stats['accepted'] = (isset($pidstat['submissions']['accepted']) ? $pidstat['submissions']['accepted'] : 0);
                        $stats['not_accepted'] = (isset($pidstat['submissions']['not_accepted']) ? $pidstat['submissions']['not_accepted'] : 0);
                        
                    }
                    if (!Yii::app()->user->isGuest && isset($userstat['users']) && isset($userstat['users'][Yii::app()->user->id])){
                        $upidstat = $userstat['users'][Yii::app()->user->id]['problems'];
                        if (is_array($upidstat['accepted']) && in_array($problem->id, $upidstat['accepted'])){
                            $stats['issolved'] = 'yes';
                        } else if (is_array($upidstat['not_accepted']) && in_array($problem->id, $upidstat['not_accepted'])){
                            $stats['issolved'] = 'no';
                        } else {
                            $stats['issolved'] = 'nan';
                        }
                    }
                    if (count($stats) > 0){
                        $item['stats'] = $stats;
                    }
                    $problemsetitems[] = $item;
                }
            }
        }
        $this->render('list', array(
            'problemsetitems' => $problemsetitems,
            'problemset' => $problemset
        ));
    }

}
