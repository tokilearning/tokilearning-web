<?php

class UserRankWidget extends CWidget {

    public $count = 5;

    public function run() {
        $statistics = StatisticsHandler::instance();
        $userstats = $statistics->getUserStat();
        $ranks = array();
        if (isset($userstats['users'])) {
            $r = array_slice($userstats['users'], 0, $this->count, true);
            foreach ($r as $idx => $val) {
                //$ranks[] = $idx;
                $ranks[] = array('id' => $idx, 'count' => count($val['problems']['accepted']));
            }
            //var_dump($userstats);
            $this->render('userrank', array(
                'ranks' => $ranks,
                'update_time' => $userstats['last_update']
            ));
        }
    }

}
