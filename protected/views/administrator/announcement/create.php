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
<div>
    <?php $this->widget('ext.ckeditor.CKEditor', array(
        'model' => $model,
        'attribute' => 'content',
        'editorTemplate' => 'advanced',
        'toolbar' => array(
            array('Bold', 'Italic', '-', 'Image', 'Link', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'NumberedList', 'BulletedList', '-', 'Styles','Format', '-', 'Source', '-', 'About')
        ),
        'width' => '600px'
    ));?>
</div>
<?php echo CHtml::error($model, 'content');?>
<br/>
<?php echo CHtml::submitButton('Simpan');?>
<?php echo CHtml::endForm();?>