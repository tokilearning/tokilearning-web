<?php
$this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $problems,
        'columns' => array(
            array (
                'name' => 'title',
                'value' => '$data->title',
                'header' => 'Judul',
                'sortable' => true,
                'type' => 'raw'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}{update}',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'view\', array(\'id\' => $data->id))',
                'viewButtonOptions' => array('target' => '_blank'),
                'updateButtonOptions' => array('target' => '_blank'),
                'buttons' => array(
                    'view' => array(
                        'label' => 'Lihat soal',
                        'url' => 'Yii::app()->controller->createUrl(\'supervisor/problem/view\', array(\'id\' => $data->primaryKey))',
                    ),
                    'update' => array(
                        'label' => 'Sunting soal',
                        'url' => 'Yii::app()->controller->createUrl(\'supervisor/problem/update\', array(\'id\' => $data->primaryKey))',
                    )
                )
            )
        ),
        'selectableRows' => 30,
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        'id' => 'problemgridview',
    ));

?>
