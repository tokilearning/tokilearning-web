<?php $this->setPageTitle("Sunting Soal");?>
<?php $this->renderPartial('_menu');?>
<?php $this->renderPartial('_updateheader', array('model' => $model));?>

<?php
Yii::import('ext.evaluator.ProblemTypeHandler');
$handler = ProblemTypeHandler::getHandler($model);
$handler->problemUpdateWidget(array('problem' => $model));
?>
