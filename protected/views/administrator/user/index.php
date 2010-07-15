<?php $this->setPageTitle("Pengguna");?>
<?php $this->renderPartial('_menu'); ?>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        'username',
        array(
            'name' => 'full_name',
            'value' => '$data->getFullnameLink()',
            'type' => 'raw'
        ),
        //'join_time',
        array(
            'name' => 'last_login',
            'value' => 'CDateHelper::timespanAbbr($data->last_login)',
            'type' => 'raw'
        ),
        array(// display a column with "view", "update" and "delete" buttons
            'class' => 'CButtonColumn',
        ),
    ),
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
));
?>