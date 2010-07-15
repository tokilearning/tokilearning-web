<?php $this->setPageTitle("Jawaban");?>
<?php $this->renderPartial('_menu');?>
<?php
Yii::import('ext.evaluator.ProblemTypeHandler');
$handler = ProblemTypeHandler::getHandler($model);
$handler->submissionUpdateWidget(
            array(
                'submission' => $model,
            )
        );
?>