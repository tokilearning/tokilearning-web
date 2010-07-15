<?php $this->setPageTitle("Bundel Soal");?>
<?php $this->renderPartial('_menu'); ?>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        'name',
        array(
            'name' => 'created_date',
            'value' => 'CDateHelper::timespanAbbr($data->created_date)',
            'type' => 'raw'
        ),
        array(
            'name' => 'status',
            'value' => '$data->getStatus()'
        ),
        array(
            'name' => 'parent_id',
            'value' => '$data->parent->name'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}{publish}{unpublish}',
            'buttons' => array(
                'publish' => array(
                    'label' => 'Publish',
                    'imageUrl' => Yii::app()->request->baseUrl."/images/icons/sound-icon-16px.png",
                    'url' => 'Yii::app()->controller->createUrl(\'publish\', array(\'id\' => $data->primaryKey))',
                    'visible' => '!$data->isPublished()'
                ),
                'unpublish' => array(
                    'label' => 'Unpublish',
                    'imageUrl' => Yii::app()->request->baseUrl."/images/icons/sound-off-icon-16px.png",
                    'url' => 'Yii::app()->controller->createUrl(\'unpublish\', array(\'id\' => $data->primaryKey))',
                    'visible' => '$data->isPublished()'
                )
            )
        ),
    ),
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
));
?>