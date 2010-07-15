<?php $this->setPageTitle("Daftar Soal");?>
<?php $this->renderPartial('_menu');?>

<?php Yii::app()->clientScript->registerScript('filter-js','
    $(\'#filter\').change(function(){
        $(\'#problemgridview\').yiiGridView.update(\'problemgridview\', {
            url:\'?filter=\'+$(this).val()
        });
    });
');?>

<?php echo CHtml::beginForm();?>
<strong>Saring</strong>
<?php echo CHtml::dropDownList('filter', 'all', array(
    'all' => 'Seluruh Soal',
    'mine' => 'Soal Saya'
));?>
<?php echo CHtml::endForm();?>
<br/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array (
                'name' => 'id',
                'value' => '$data->primaryKey',
                'header' => 'ID',
                'sortable' => false
        ),
        'title',
        array(
            'name' => 'author_id',
            'value' => '$data->author->getFullnameLink()',
            'type' => 'raw'
        ),
        array(
            'name' => 'visibility',
            'value' => '$data->getVisibility()'
        ),
        array(
            'name' => 'created_date',
            'value' => 'CDateHelper::timespanAbbr($data->created_date)',
            'type' => 'raw'
        ),
        array(
            'name' => 'modified_date',
            'value' => 'CDateHelper::timespanAbbr($data->modified_date)',
            'type' => 'raw'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}{publish}{unpublish}',
            'buttons' => array(
                'publish' => array(
                    'label' => 'Publish',
                    'imageUrl' => Yii::app()->request->baseUrl."/images/icons/sound-icon-16px.png",
                    'url' => 'Yii::app()->controller->createUrl(\'publish\', array(\'id\' => $data->primaryKey))',
                    'visible' => '$data->visibility != Problem::VISIBILITY_PUBLIC'
                ),
                'unpublish' => array(
                    'label' => 'Unpublish',
                    'imageUrl' => Yii::app()->request->baseUrl."/images/icons/sound-off-icon-16px.png",
                    'url' => 'Yii::app()->controller->createUrl(\'unpublish\', array(\'id\' => $data->primaryKey))',
                    'visible' => '$data->visibility != Problem::VISIBILITY_DRAFT'
                )
            )
        ),
    ),
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'template' => '{summary} {pager} <br/> {items} {pager}',
    'enablePagination' => true,
    'id' => 'problemgridview',
    'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
));
?>