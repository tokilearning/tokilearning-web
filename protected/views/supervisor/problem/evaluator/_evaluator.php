<?php
Yii::app()->clientScript->registerCss('uploadform-css', '
    .uploadform {background: #eee; border:1px solid #ccc; margin: 10px 0; padding: 2px 10px;width:97%;}
    .uploadform input[type=file] {width:100%;}
    .uploadform div.MultiFile-label {}
    .uploadform div.MultiFile-label a.MultiFile-remove {color:#ff0000;text-decoration:none;font-weight:bold;}
    .uploadform div.MultiFile-label a.MultiFile-remove:hover {text-decoration:none;}
    .uploadform div.MultiFile-label span.MultiFile-title {display:inline;font-weight:bold;}
    #config-wrapper {padding:5px;border:1px solid #ccc;}
');
?>
<div>
<h4>Sunting Konfigurasi Soal</h4>

<?php
if (!isset($evalActiveTab) || $evalActiveTab == null){
    $evalActiveTab = 'form';
}
$this->widget('CTabView',
        array(
            'tabs' => array(
                'form' => array(
                    'title' => 'Form',
                    'view' => 'evaluator/_configform',
                    'data' => array(
                        'model' => $model
                    )
                ),
                'manual' => array(
                    'title' => 'Manual',
                    'view' => 'evaluator/_configmanual',
                    'data' => array(
                        'model' => $model
                    )
                ),
            ),
            'id' => 'problem-config-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css",
            'activeTab' => $evalActiveTab
        )
);
?>
    
<hr/>
<h4>Berkas Evaluator</h4>
<?php echo CHtml::beginForm($this->createUrl('uploadEvaluatorFile', array('id' => $model->id)), 'post', array('enctype' => 'multipart/form-data'));?>
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
            <?php echo CHtml::submitButton('Unggah');?>
        </span>
    </div>
</div>
<?php echo CHtml::endForm();?>
<?php
$dataProvider = new ArrayDataProvider($model->getEvaluatorFileList());
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
                        'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'getEvaluatorFile\', array(\'id\' => Yii::app()->controller->loadModel()->id, \'file\' => $data[\'name\']))',
                        'viewButtonLabel' => 'Download',
                        'viewButtonImageUrl' => Yii::app()->request->baseUrl."/images/icons/save-16px.png",
                        'updateButtonUrl' => 'Yii::app()->controller->createUrl(\'updateEvaluatorFile\', array(\'id\' => Yii::app()->controller->loadModel()->id, \'file\' => $data[\'name\']))',
                        'updateButtonOptions' => array('target' => '_blank'),
                        'deleteButtonUrl' => 'Yii::app()->controller->createUrl(\'deleteEvaluatorFile\', array(\'id\' => Yii::app()->controller->loadModel()->id, \'file\' => $data[\'name\']))',
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
</div>