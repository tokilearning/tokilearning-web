<?php $this->setPageTitle("Paste Bin");?>
<?php $this->renderPartial('_menu'); ?>

<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'id',
            array(
                'name' => 'owner_id',
                'value' => '$data->owner->getFullnameLink()',
                'type' => 'raw'
            ),
            array(
                'name' => 'created_date',
                'value' => 'CDateHelper::timespanAbbr($data->created_date)',
                'type' => 'raw'
            ),
            'type',
            array(// display 'create_time' using an expression
                'name' => 'status',
                'value' => '$data->getStatus()',
            ),
            array(// display a column with "view", "update" and "delete" buttons
                'class' => 'CButtonColumn',
                'template' => '{view}{delete}',
            )
        ),
        'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    ));
?>