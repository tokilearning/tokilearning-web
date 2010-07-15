<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Anggota</span>
        <span>
    <?php $this->widget('CAutoComplete',
          array(
             'name' => 'supervisor_lookup',
             'url' => array('supervisorlookup'),
             'max' => 10,
             'minChars' => 1,
             'delay' => 500,
             'matchCase' => false,
             'htmlOptions' => array('size'=>'30'),
             'methodChain' => ".result(function(event,item){\$(\"#addsupervisor_id\").val(item[1]);})",
             ));
    ?>
    <?php echo CHtml::hiddenField('addsupervisor_id'); ?>
    <?php echo CHtml::ajaxButton('Tambah', $this->createUrl('addsupervisor'), array(
        'type' => 'GET',
        'data'=> array(
                "memberid"=> "js:$(\"#addsupervisor_id\").val()",
            ),
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#supervisorsgridview').yiiGridView.update('supervisorsgridview');}"
    ));?>
        </span>
    </div>
</div>
<br/>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $supervisorsDataProvider,
    'columns' => array(
        'id',
        'username',
        'full_name',
        array(// display a column with "view", "update" and "delete" buttons
            'class' => 'CButtonColumn',
            'template' => '{view} {delete}',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' => $data->primaryKey))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl(\'removeSupervisor\', array(\'memberid\' => $data->primaryKey))',
        ),
    ),
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    'id' => 'supervisorsgridview',
));
?>