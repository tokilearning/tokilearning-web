<?php $this->setPageTitle("Buat Grup Pengguna");?>
<?php $this->renderPartial('_menu'); ?>

<div class="dtable">
    <?php echo CHtml::beginForm();?>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'name');?></span>
        <span><?php echo CHtml::activeTextField($model, 'name');?></span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'description');?></span>
        <span><?php echo CHtml::activeTextArea($model, 'description');?></span>
    </div>
    <div class="drow">
        <span></span>
        <span><?php echo CHtml::submitButton('Buat');?></span>
    </div>
    <?php echo CHtml::errorSummary($model);?>
    <?php echo CHtml::endForm();?>
</div>