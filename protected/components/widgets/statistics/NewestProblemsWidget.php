<?php

class NewestProblemsWidget extends CWidget {

    public $count = 5;

    public function run() {
        //TODO: Cache
        $criteria = new CDbCriteria(array(
                    'select' => array('id', 'title', 'created_date'),
                    'condition' => 'visibility = ' . Problem::VISIBILITY_PUBLIC,
                    'order' => 'id DESC',
                    'limit' => $this->count,
                ));
        $problems = Problem::model()->findAll($criteria);
        $this->render('newestproblems', array(
            'newproblems' => $problems
        ));
    }

}