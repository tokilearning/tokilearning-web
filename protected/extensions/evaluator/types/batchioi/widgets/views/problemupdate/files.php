<?php
Yii::app()->clientScript->registerCss('files-css', '
    h3 {border-bottom:1px dotted #bbb;}
    .uploadform {background: #eee; border:1px solid #ccc; margin: 10px 0; padding: 2px 10px;width:97%;}
    .uploadform input[type=file] {width:100%;}
    .uploadform div.MultiFile-label {}
    .uploadform div.MultiFile-label a.MultiFile-remove {color:#ff0000;text-decoration:none;font-weight:bold;}
    .uploadform div.MultiFile-label a.MultiFile-remove:hover {text-decoration:none;}
    .uploadform div.MultiFile-label span.MultiFile-title {display:inline;font-weight:bold;}
    #config-wrapper {padding:5px;border:1px solid #ccc;}
    ');
?>
<h3>Berkas Evaluator</h3>
<?php echo CHtml::beginForm('?action=files&action2=uploadevaluatorfile', 'post', array('enctype' => 'multipart/form-data')); ?>
<div class="uploadform dtable">
    <div class="drow">
        <span class="shead">Unggah berkas</span>
        <span>
            <?php
            $this->widget('system.web.widgets.CMultiFileUpload', array(
                'name' => 'evaluatorfileupload',
                'id' => 'evaluatorfileupload'
            ));
            ?>
        </span>
        <span>
            <?php echo CHtml::submitButton('Unggah'); ?>
        </span>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
<?php
            $arrayEvaluatorFiles = $problem->getFileList('evaluator/files');
            $evaluatorDataProvider = new CArrayDataProvider($arrayEvaluatorFiles, array(
                        'pagination' => array(
                            'pageSize' => 20,
                        ),
                    ));
            $this->widget('zii.widgets.grid.CGridView',
                    array(
                        'dataProvider' => $evaluatorDataProvider,
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
                                'template' => '{view}{remove}',
                                //'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'getEvaluatorFile\', array(\'id\' => Yii::app()->controller->loadModel()->id, \'file\' => $data[\'name\']))',
                                'viewButtonUrl' => '\'?action=files&action2=downloadevaluatorfile&filename=\'.$data[\'name\']',
                                'viewButtonLabel' => 'Download',
                                'viewButtonImageUrl' => Yii::app()->request->baseUrl . "/images/icons/save-16px.png",
                                'buttons' => array(
                                    'remove' => array(
                                        'url' => '\'?action=files&action2=deleteevaluatorfile&filename=\'.$data[\'name\']',
                                        'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/delete-16px.png",
                                        'options' => array(
                                            'onclick' => 'return confirm(\'Are you sure you want to delete this item?\');'
                                        )
                                    ),
                                ),
                            )
                        ),
                        'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
                        'template' => '{summary} {pager} <br/> {items} {pager}',
                        'enablePagination' => true,
                        'id' => 'evaluatorgridview',
                        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
                    )
            );
?>

            <h3>Berkas Tampilan</h3>
<?php echo CHtml::beginForm('?action=files&action2=uploadviewfile', 'post', array('enctype' => 'multipart/form-data')); ?>
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
            <?php echo CHtml::submitButton('Unggah'); ?>
        </span>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
<?php
            $arrayViewFiles = $problem->getFileList('view/files');
            $viewDataProvider = new CArrayDataProvider($arrayViewFiles, array(
                        'pagination' => array(
                            'pageSize' => 20,
                        ),
                    ));
            $this->widget('zii.widgets.grid.CGridView',
                    array(
                        'dataProvider' => $viewDataProvider,
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
                                'template' => '{view}{remove}',
                                //'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'getEvaluatorFile\', array(\'id\' => Yii::app()->controller->loadModel()->id, \'file\' => $data[\'name\']))',
                                'viewButtonUrl' => '\'?action=files&action2=downloadviewfile&filename=\'.$data[\'name\']',
                                'viewButtonLabel' => 'Download',
                                'viewButtonImageUrl' => Yii::app()->request->baseUrl . "/images/icons/save-16px.png",
                                'buttons' => array(
                                    'remove' => array(
                                        'url' => '\'?action=files&action2=deleteviewfile&filename=\'.$data[\'name\']',
                                        'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/delete-16px.png",
                                        'options' => array(
                                            'onclick' => 'return confirm(\'Are you sure you want to delete this item?\');'
                                        )
                                    ),
                                ),
                            )
                        ),
                        'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
                        'template' => '{summary} {pager} <br/> {items} {pager}',
                        'enablePagination' => true,
                        'id' => 'descriptiongridview',
                        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
                    )
            );
?>
