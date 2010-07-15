<?php
Yii::app()->clientScript->registerCss('submitform-css', '
    #submitform {margin:5px; padding:10px;border:1px solid #bbb;}
');
?>
<div id="submitform">
<?php if ($submission != null && $submission->hasErrors($answer)) :?>
    <?php echo CHtml::errorSummary($submission);?>
<?php endif;?>
<?php echo CHtml::beginForm($this->createUrl('submitAnswer', array('id' => $model->id)), 'post', array('enctype' => 'multipart/form-data'));?>
<?php echo ProblemHelper::renderSubmitForm($model);?>
<?php echo CHtml::submitButton('Kumpul');?>
<?php echo CHtml::endForm();?>
</div>