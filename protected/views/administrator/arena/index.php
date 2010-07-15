<?php $this->setPageTitle("Daftar Arena");?>
<?php $this->renderPartial('_menu');?>

<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'id',
            'name',
            array(
                'name' => 'creator_id',
                'value' => '$data->creator->getFullnameLink()',
                'type' => 'raw'
            ),
            'status',
            array(// display a column with "view", "update" and "delete" buttons
                'class' => 'CButtonColumn',
                'template' => '{update}{delete}',
            ),
        ),
        'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    ));
?>