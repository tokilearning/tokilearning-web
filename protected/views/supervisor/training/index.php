<?php $this->renderPartial('_menu');?>
<a href="<?php echo Yii::app()->controller->createUrl('create')?>" class="linkbutton">Baru</a><br /><br />
<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'id',
            'name',
            array(
                'name' => 'created_time',
                'value' => 'CDateHelper::timespanAbbr($data->created_time)',
                'type' => 'raw'
            ),
            array(
                'name' => 'creator_id',
                'value' => '$data->creator->getFullnameLink()',
                'type' => 'raw'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}{update}{delete}',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'view\', array(\'id\' => $data->id))',
                'viewButtonOptions' => array('target' => '_blank'),
                'updateButtonOptions' => array('target' => '_blank'),
                'buttons' => array(
                    'regrade' => array(
                        'label' => 'Regrade',
                        'imageUrl' => Yii::app()->request->baseUrl."/images/icons/repeat-16px.png",
                        'url' => 'Yii::app()->controller->createUrl(\'regrade\', array(\'id\' => $data->primaryKey))',
                    )
                )
            )
        ),
        
        'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
        'emptyText' => 'Belum ada latihan dibuat',
        'enablePagination' => true,

        'selectableRows' => 30,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
        'id' => 'submissiongridview',
    ));
?>