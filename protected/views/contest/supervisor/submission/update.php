<?php
Yii::import('ext.evaluator.ProblemTypeHandler');
$handler = ProblemTypeHandler::getHandler($model);
$handler->submissionUpdateWidget(
            array(
                'submission' => $model,
            )
        );
?>