<?php $this->setPageTitle("Jawaban");?>
<?php
Yii::import('ext.evaluator.ProblemTypeHandler');
$handler = ProblemTypeHandler::getHandler($model);
$handler->submissionViewWidget(
            array(
                'submission' => $model,
                'viewLevel' => 1,
            )
        );
?>