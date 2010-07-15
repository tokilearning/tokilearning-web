<?php

class MostSubmittedProblemsWidget extends CWidget {

    public $count = 5;
    public $duration = NULL;
    public $title = "Soal Terpopuler";

    public function run() {
        $statistics = StatisticsHandler::instance();
        $problemstat = $statistics->getProblemStat();
        $problemranks = array();
        if (isset($problemstat['problems'])) {
			//echo "TEST";
            $r = null;
            if (!(isset($this->duration))) {
                $r = array_slice($problemstat['problems'], 0, $this->count, true);
                foreach ($r as $idx => $val) {
                    //$ranks[] = $idx;
                    $ranks[] = array('id' => $idx,
                        'count' => $val['submissions']['count'],
                        'accepted' => $val['submissions']['accepted'],
                        'not_accepted' => $val['submissions']['not_accepted']
                    );
                }
            } else {
				
                if (isset($problemstat['popular'][$this->duration])) {
					
                    $r = array_slice($problemstat['popular'][$this->duration], 0, $this->count, true);
                    foreach ($r as $idx => $ignore_me) {
                        //$ranks[] = $idx;
                        $val = $problemstat['problems'][$idx];
                        $ranks[] = array('id' => $idx,
                            'count' => $val['submissions']['count'],
                            'accepted' => $val['submissions']['accepted'],
                            'not_accepted' => $val['submissions']['not_accepted']
                        );
                    }
                }
            }
            if (isset($ranks)) {
                $this->render('mostsubmittedproblems', array(
                    'ranks' => $ranks,
                    'update_time' => $problemstat['last_update']
                ));
            }
        }
    }

}
