<?php

Yii::import("ext.evaluator.base.StandardProblemUpdateWidgetBase");

class SimplebatchProblemUpdateWidget extends StandardProblemUpdateWidgetBase {

    protected function updateConfiguration() {
        if (isset($_POST['config'])) {
            $config = $_POST['config'];
            $this->problem->setConfig('time_limit', $config['time_limit']);
            $this->problem->setConfig('memory_limit', $config['memory_limit']);
            $testcases = array();
            if (isset($config['testcases'])) {
                ksort(&$config['testcases']);
                foreach ($config['testcases'] as $val) {
                    $testcases[] = $val;
                }
            }
            $this->problem->setConfig('testcases', $testcases);
            $this->problem->save();
            return true;
        }
    }

}
