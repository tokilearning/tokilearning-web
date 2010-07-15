<div>
    <div class="dtable">
        <div class="drow">
            <span class="name"><?php echo CHtml::activeLabel($model, 'id');?></span>
            <span><?php echo $model->id;?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo CHtml::activeLabel($model, 'author');?></span>
            <span><?php echo $model->author->getFullnameLink();?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo CHtml::activeLabel($model, 'problem_type_id');?></span>
            <span><?php echo $model->problemtype->name;?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo CHtml::activeLabel($model, 'token');?></span>
            <span><?php echo $model->token;?></span>
        </div>
        <div class="drow">
            <span class="name">Directory</span>
            <span><?php echo $model->getDirectoryPath();?></span>
        </div>
    </div>
</div>
<hr/>
<?php echo CHtml::beginForm($this->createUrl('updateinformation', array('id' => $model->id))); ?>
<?php echo CHtml::errorSummary($model); ?>
<div style="padding:5px;">
<div>
    <strong><?php echo CHtml::activeLabel($model, 'title');?></strong>
    <?php echo CHtml::activeTextField($model, 'title', array('style' => 'width:95%;')); ?>
</div>
<div>
    <strong><?php echo CHtml::activeLabel($model, 'visibility');?></strong>
    <?php echo CHtml::activeDropDownList($model, 'visibility', Problem::getVisibilityStrings());?>
</div>
<div>
    <strong><?php echo CHtml::activeLabel($model, 'description');?></strong>
    <?php echo CHtml::error($model, 'description'); ?>
    <?php echo CHtml::activeTextArea($model, 'description', array('style' => 'width:95%;height:150px;')); ?>
</div>
<?php echo CHtml::link('Hapus', $this->createUrl('delete', array('id' => $model->id)),
        array('onclick' => 'return confirm("Are you sure you want to delete this item?");'));?>&nbsp;
<?php echo CHtml::submitButton('Simpan'); ?>
</div>
<?php echo CHtml::endForm(); ?>