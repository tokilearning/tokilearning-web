<?php $this->setPageTitle("Aktivitas"); ?>
<?php $this->renderPartial('_menu'); ?>

<?php echo CHtml::link('Download CSV', $this->createUrl('downloadActivity'), array('class' => 'linkbutton')); ?>
<?php

$this->widget('zii.widgets.grid.CGridView',
        array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                array(
                    'name' => 'username',
                    'header' => 'Username',
                    'value' => '$data[\'username\']'
                ),
                array(
                    'name' => 'full_name',
                    'header' => 'Nama Panjang',
                    'value' => 'CHtml::link($data[\'full_name\'], Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' =>$data[\'id\'] )))',
                    'type' => 'raw'
                ),
                array(
                    'name' => 'last_activity',
                    'header' => 'Aktivitas',
                    'value' => 'CDateHelper::timespanAbbr($data[\'last_activity\'])',
                    'type' => 'raw'
                ),
                array(
                    'name' => 'last_page',
                    'header' => 'Halaman Terakhir'
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