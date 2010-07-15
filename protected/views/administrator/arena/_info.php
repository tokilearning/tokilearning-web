<div class="dtable">
    <?php echo CHtml::beginForm();?>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'name');?></span>
        <span><?php echo CHtml::activeTextField($model, 'name');?></span>
    </div>
    <div class="drow">
        <span></span>
        <span><?php echo CHtml::submitButton('Ubah');?></span>
    </div>
    <?php echo CHtml::errorSummary($model);?>
    <?php echo CHtml::endForm();?>
</div>