<?php $this->setPageTitle("Daftar Kontes");?>
<?php $this->renderPartial('_menu'); ?>

<?php Yii::app()->clientScript->registerScript('filter-js','
    $(\'#filter\').change(function(){
        $(\'#contestgridview\').yiiGridView.update(\'contestgridview\', {
            url:\'?filter=\'+$(this).val()
        });
    });
');?>

<?php echo CHtml::beginForm();?>
<strong>Saring</strong>
<?php echo CHtml::dropDownList('filter', 'current', array(
    'current' => 'Kontes berlangsung',
    'current_active' => 'Kontes berlangsung yang diikuti',
    'past' => 'Kontes lawas',
    'past_active' => 'Kontes lawas yang diikuti',
    'all' => 'Seluruh kontes',
    'all_active' => 'Seluruh kontes yang diikuti'
));?>
<?php echo CHtml::endForm();?>
<br/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        'name',
        array(
            'name' => 'owner_id',
            'value' => '$data->owner->getFullnameLink()',
            'type' => 'raw'
        ),
        array(
            'name' => 'start_time',
            'value' => 'CDateHelper::timespanAbbr($data->start_time)',
            'type' => 'raw'
        ),
        array(
            'name' => 'end_time',
            'value' => 'CDateHelper::timespanAbbr($data->end_time)',
            'type' => 'raw'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}'
        ),
    ),
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
    'id' => 'contestgridview'
));
?>