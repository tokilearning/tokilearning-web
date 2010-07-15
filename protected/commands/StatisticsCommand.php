<?php

class StatisticsCommand extends CConsoleCommand {

    public function run($args) {
        $statistics = StatisticsHandler::instance();
        $statistics->computeStatistics();
    }

}