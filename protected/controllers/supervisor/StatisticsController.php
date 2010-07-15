<?php

class StatisticsController extends CSupervisorController {

    public $defaultAction = 'user';
    public $pageTitle = 'Statistik';

    public function actionUser() {
        $statistics = StatisticsHandler::instance();
        $userstat = $statistics->getUserStat();
        foreach ($userstat['users'] as $id => $val) {
	   $u = User::model()->findByPk($id, array('select' => array('id', 'full_name')));
           $users[] = array(
		'id' => $id,
		'full_name' => $u->full_name,
		's_count' => $val['submissions']['count'],
		'p_solved' => count($val['problems']['accepted']),
		's_accepted' => $val['submissions']['accepted'],
		's_not_accepted' => $val['submissions']['not_accepted'],
		's_lang_cpp' => $val['submissions']['source_lang']['cpp'],
		's_lang_c' => $val['submissions']['source_lang']['c'],
		's_lang_pas' => $val['submissions']['source_lang']['pas'],
	   ); 
        }
        $this->render('user', array(
            'users' => $users,
            'last_update' => $userstat['last_update']
        ));
    }

}
