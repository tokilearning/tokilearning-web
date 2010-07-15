<div>
    <h4>Sunting Tampilan Soal</h4>
    <div>
        <?php echo CHtml::beginForm('?action=display');?>
        <p class="error" style="border: 1px dotted #bbb;padding:0px 5px;">To include image use link "<em>?action=renderviewfile&amp;filename=<strong>filename</strong></em>", where <strong>filename</strong> is a file from view files </p>
        <?php $this->widget('ext.ckeditor.CKEditor', array(
            'name' => 'descriptionfile',
            'value' => $description,
            'editorTemplate' => 'advanced',
            'toolbar' => array(
                array('Bold', 'Italic', '-', 'Image', 'Link', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'NumberedList', 'BulletedList', '-', 'Styles','Format', '-', 'Source', '-', 'About')
            ),
            'width' => '600px',
        ));?>
        <br/>
        <?php echo CHtml::submitButton('Simpan');?>
        <?php echo CHtml::endForm();?>
    </div>
    <br/>
<hr/>
</div>