<?php echo CHtml::beginForm($this->createUrl('updateConfigurationForm', array('id' => $model->id)));?>
<?php ProblemHelper::renderConfigForm($model);?>
<?php echo CHtml::submitButton('Simpan');?>
<?php echo CHtml::endForm();?>