<?php $this->renderPartial('_menu'); ?>
<p>
<?php echo CHtml::link('Baru', array('create') , array('class' => 'linkbutton')); ?>
</p>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        array(
            'name' => 'name',
            'value' => 'CHtml::link($data->name, Yii::app()->controller->createUrl(\'view\', array(\'id\' => $data->id)))',
            'type' => 'raw'
        ),
        array(
            'name' => 'created_time',
            'value' => 'CDateHelper::timespanAbbr($data->created_time)',
            'type' => 'raw'
        ),
        array(
            'name' => 'nextChapter',
            'value' => 'CHtml::link($data->nextChapter->name, Yii::app()->controller->createUrl(\'view\', array(\'id\' => $data->nextChapter->id)), array(\'target\' => \'_blank\'))',
            'type' => 'raw',
        ),
        array(
            'name' => 'previousChapter',
            'value' => 'CHtml::link($data->previousChapter->name, Yii::app()->controller->createUrl(\'view\', array(\'id\' => $data->previousChapter->id)), array(\'target\' => \'_blank\'))',
            'type' => 'raw',
        ),
        array(
            'name' => 'firstSubChapter',
            'value' => 'CHtml::link($data->firstSubChapter->name, Yii::app()->controller->createUrl(\'view\', array(\'id\' => $data->firstSubChapter->id)), array(\'target\' => \'_blank\'))',
            'type' => 'raw',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'view\', array(\'id\' => $data->id))',
            'viewButtonOptions' => array('target' => '_blank'),
            'updateButtonOptions' => array('target' => '_blank'),
            'buttons' => array(
                'regrade' => array(
                    'label' => 'Regrade',
                    'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/repeat-16px.png",
                    'url' => 'Yii::app()->controller->createUrl(\'regrade\', array(\'id\' => $data->primaryKey))',
                )
            )
        )
    ),
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'emptyText' => 'Belum ada latihan dibuat',
    'enablePagination' => true,
    'selectableRows' => 30,
    'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
    'id' => 'submissiongridview',
));
?>