<?php

Yii::import("ext.evaluator.base.StandardProblemUpdateWidgetBase");

class ArchiveProblemUpdateWidget extends StandardProblemUpdateWidgetBase {

    protected function updateConfiguration() {
        if (isset($_POST['config'])) {
            $config = $_POST['config'];
            /* $this->problem->setConfig('time_limit', $config['time_limit']);
              $this->problem->setConfig('memory_limit', $config['memory_limit']); */
            $this->problem->setConfig('sample_contest', $config['sample_contest']);
            $this->problem->setConfig('command_line', $config['command_line']);
            $this->problem->setConfig('checker_name', $config['checker_name']);
            $testcases = array();
            if (isset($config['testcases'])) {
                ksort(&$config['testcases']);
                foreach ($config['testcases'] as $val) {
                    $testcases[] = $val;
                }
            }

            $batchpoints = array();
            if (isset($config['batchpoints'])) {
                foreach ($config['batchpoints'] as $key => $val) {
                    $batchpoints[$key] = $val;
                }
            }

            uasort($testcases, 'StandardProblemUpdateWidgetBase::compare');
            $this->problem->setConfig('testcases', $testcases);
            $this->problem->setConfig('batchpoints', $batchpoints);
            $this->problem->save();
            return true;
        }
    }

}
