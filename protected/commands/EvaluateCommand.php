<?php
class EvaluateCommand extends CConsoleCommand {
    
    public function run($args) {
        echo sprintf("Evaluator started\n");
        for (;;){
            $submission = Submission::getFirstPending();
            if ($submission == null){
                echo sprintf("No submission\n");
                sleep(10); //sleep 20 second
                continue;
            } else {
                echo sprintf("Find submission : #%d\n", $submission->id);
                Dispatcher::dispatch($submission);
            }
        }
    }
}