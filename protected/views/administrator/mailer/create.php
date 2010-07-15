<?php $this->setPageTitle("Buat Email"); ?>
<?php $this->renderPartial('_menu'); ?>
<?php Yii::app()->clientScript->registerCss('mailer-css', '

    
'); ?>
<?php
$assetpath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '/csvtemplate.csv';
$publishpath = Yii::app()->getAssetManager()->publish($assetpath, false, -1, true);
?>
<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>
<div>
    <div>
        <?php echo CHtml::activeLabel($model, 'subject'); ?>&nbsp;
        <?php echo CHtml::activeTextField($model, 'subject', array('style' => 'width:300px;')); ?>
    </div>
    <div>
        <?php echo CHtml::activeLabel($model, 'from'); ?>&nbsp;
        <?php echo CHtml::activeTextField($model, 'from', array('style' => 'width:300px;')); ?>
        <?php echo CHtml::activeTextField($model, 'fromName', array('style' => 'width:300px;')); ?>
    </div>
    <div>
        <?php echo CHtml::activeLabel($model, 'replyTo'); ?>&nbsp;
        <?php echo CHtml::activeTextField($model, 'replyTo', array('style' => 'width:300px;')); ?>
        <?php echo CHtml::activeTextField($model, 'replyToName', array('style' => 'width:300px;')); ?>
    </div>
    <div>
        <?php echo CHtml::activeLabel($model, 'template'); ?>
        <?php echo CHtml::activeTextArea($model, 'template', array('style' => 'display:block;width:500px;height:200px;')); ?>
    </div>
    <div>
        <?php echo CHtml::activeLabel($model, 'csvfile'); ?>
        <?php echo CHtml::activeFileField($model, 'csvfile'); ?>
        <?php echo CHtml::link('CSV Template', $publishpath); ?>
    </div>
    <div><?php echo CHtml::errorSummary($model); ?><br/></div>
    <div><?php echo CHtml::submitButton('Kirim'); ?></div>
</div>
<?php echo CHtml::endForm(); ?>