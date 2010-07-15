<?php

Yii::import("ext.evaluator.types.simple.SimpleEvaluator");

class SimpleEvaluateCommand extends CConsoleCommand {

    public function run($args) {
        /*$data = array(
            'memorylimit' => 16000000,
            'timelimit' => 3000,
            'testcaseno' => 2
        );
        file_put_contents("/home/karol/Documents/Projects/lx-test/tc/config.json", json_encode($data));*/
        
        $evaluator = new SimpleEvaluator("" , $args[0] , $args[1] , $args[2]);
        $evaluator->doCompile();
        $evaluator->doExecute();
        $evaluator->cleanup();
        
        print_r($evaluator->getResult());
    }

}

?>
