<?php $this->setPageTitle("Pengumuman");?>
<?php $this->renderPartial('_menu');?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'emptyText' => 'Belum ada pengumuman',
    'summaryText' => 'Menampilkan {end} pengumuman dari {count}. ',
    'columns' => array(
        'id',
        array(
            'name' => 'author_id',
            'value' => '$data->author->getFullnameLink()',
            'type' => 'raw'
        ),
        'created_date',
        array(
                'name' => 'created_date',
                'value' => 'CDateHelper::timespanAbbr($data->created_date)',
                'type' => 'raw'
            ),
        'title',
        array(
            'name' => 'status',
            'value' => '$data->getStatus()'
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
        )
    ),
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
));
?>