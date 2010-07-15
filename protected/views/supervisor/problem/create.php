<?php $this->setPageTitle("Buat Soal");?>
<?php $this->renderPartial('_menu'); ?>

<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary($model); ?>
<div>
    <strong><?php echo CHtml::activeLabel($model, 'title');?></strong>
    <?php echo CHtml::activeTextField($model, 'title', array('style' => 'width:95%;')); ?>
</div>
<div>
    <strong><?php echo CHtml::activeLabel($model, 'problem_type_id');?></strong>&nbsp;
    <?php echo CHtml::activeDropDownList($model, 'problem_type_id', ProblemType::toArray());?>
</div>
<div>
    <strong><?php echo CHtml::activeLabel($model, 'description');?></strong>
    <?php echo CHtml::activeTextArea($model, 'description', array('style' => 'width:95%;height:150px;')); ?>
    <?php echo CHtml::error($model, 'description'); ?>
</div>
<?php echo CHtml::submitButton('Simpan'); ?>
<?php echo CHtml::endForm(); ?>