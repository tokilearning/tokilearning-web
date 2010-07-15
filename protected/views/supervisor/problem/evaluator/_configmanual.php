<?php echo CHtml::label('Berkas Konfigurasi', 'json_content');?>
<br/>
<?php echo CHtml::beginForm($this->createUrl('updateConfigurationManual', array('id' => $model->id)));?>
<?php
$config = $model->getConfigs();
$json_string = CJSON::encode($config);
$json_string = PJSON::indent($json_string);
?>
<?php echo CHtml::textArea('json_content', $json_string, array('style' => 'width:97%;height:350px;'));?>
<?php echo CHtml::submitButton('Simpan');?>
<?php echo CHtml::endForm();?>