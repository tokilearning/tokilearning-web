<?php
Yii::app()->clientScript->registerCss('uploadform-css', '
    .uploadform {background: #eee; border:1px solid #ccc; margin: 10px 0; padding: 2px 10px;width:97%;}
    .uploadform input[type=file] {width:100%;}
    .uploadform div.MultiFile-label {}
    .uploadform div.MultiFile-label a.MultiFile-remove {color:#ff0000;text-decoration:none;font-weight:bold;}
    .uploadform div.MultiFile-label a.MultiFile-remove:hover {text-decoration:none;}
    .uploadform div.MultiFile-label span.MultiFile-title {display:inline;font-weight:bold;}
');
?>
<div>
    <h4>Sunting Tampilan Soal</h4>
    <div>
        <?php echo CHtml::beginForm($this->createUrl('updateDescriptionFile', array('id' => $model->id)));?>
        <?php $this->widget('ext.ckeditor.CKEditor', array(
            'name' => 'descriptionfile',
            'value' => ProblemHelper::renderDescription($model),
            'editorTemplate' => 'advanced',
            'toolbar' => array(
                array('Bold', 'Italic', '-', 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'NumberedList', 'BulletedList', '-', 'Styles','Format', '-', 'Source', '-', 'About')
            ),
            'width' => '600px',
        ));?>
        <br/>
        <?php echo CHtml::submitButton('Simpan');?>
        <?php echo CHtml::endForm();?>
    </div>
    <br/>
<hr/>
<h4>Berkas Tampilan</h4>
<?php echo CHtml::beginForm($this->createUrl('uploadViewFile', array('id' => $model->id)), 'post', array('enctype' => 'multipart/form-data'));?>
<div class="uploadform dtable">
    <div class="drow">
        <span class="shead">Unggah berkas</span>
        <span>
            <?php
            $this->widget('system.web.widgets.CMultiFileUpload', array(
                'name' => 'viewfileupload',
                'id' => 'viewfileupload'
            ));
            ?>
        </span>
        <span>
            <?php echo CHtml::submitButton('Unggah');?>
        </span>
    </div>
</div>
<?php echo CHtml::endForm();?>
<?php
$dataProvider = new ArrayDataProvider($model->getViewFileList());
$this->widget('zii.widgets.grid.CGridView',
        array(
            'dataProvider'=>$dataProvider,
            'columns' => array(
                'name',
                array(
                    'name' => 'modified',
                    'value' => 'CDateHelper::timespanAbbr(date(\'Y-m-d H:i:s\',$data[\'modified\']))',
                    //'value' => '$data[\'modified\']',
                    'type' => 'raw'
                ),
                array(
                    'name' => 'size',
                    'value' => '\'<abbr title=\\\'\'.$data[\'size\'].\'\\\'>\'.(round($data[\'size\'] / 1024)).\' kB</abbr>\'',
                    'type' => 'raw'
                ),
                array(
                        'class' => 'CButtonColumn',
                        'template' => '{view}{update}{delete}',
                        'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'getViewFile\', array(\'id\' => Yii::app()->controller->loadModel()->id, \'file\' => $data[\'name\']))',
                        'viewButtonLabel' => 'Download',
                        'viewButtonImageUrl' => Yii::app()->request->baseUrl."/images/icons/save-16px.png",
                        'updateButtonUrl' => 'Yii::app()->controller->createUrl(\'updateViewFile\', array(\'id\' => Yii::app()->controller->loadModel()->id, \'file\' => $data[\'name\']))',
                        'updateButtonOptions' => array('target' => '_blank'),
                        'deleteButtonUrl' => 'Yii::app()->controller->createUrl(\'deleteViewFile\', array(\'id\' => Yii::app()->controller->loadModel()->id, \'file\' => $data[\'name\']))',
                )
            ),
            'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
            'template' => '{summary} {pager} <br/> {items} {pager}',
            'enablePagination' => true,
            'id' => 'displaygridview',
            'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        )
    );
?>
</div>