<?php $this->setPageTitle("Buat Pengumuman");?>
<?php $this->renderPartial('_menu');?>

<?php echo CHtml::beginForm();?>
<div><?php echo CHtml::activeTextField($model, 'title', array('style' => 'width:95%;'));?>
<?php echo CHtml::error($model, 'title');?>
</div>
<div>
    Status <?php echo CHtml::activeDropDownList($model, 'status', array(
        Announcement::STATUS_DRAFT => 'Draft',
        Announcement::STATUS_PUBLISHED => 'Published',
    ));?>
</div>
<div><?php echo CHtml::activeTextArea($model, 'content', array('style' => 'width:95%;height:150px;'));?></div>
<?php echo CHtml::error($model, 'content');?>
<?php echo CHtml::submitButton('Simpan');?>
<?php echo CHtml::endForm();?>