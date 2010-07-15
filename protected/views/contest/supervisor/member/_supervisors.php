<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Anggota</span>
        <span>
    <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
          array(
                'name' => 'supervisor_lookup',
                'sourceUrl' => array('contest/supervisor/member/supervisorlookup'),
             ));
    ?>
    <?php echo CHtml::ajaxButton('Tambah', $this->createUrl('contest/supervisor/member/addsupervisor' , array('contestid' => $this->getContest()->id)), array(
        'type' => 'GET',
        'data'=> array(
                "memberid"=> "js:$(\"#supervisor_lookup\").val()",
            ),
        'success' => "function(data, textStatus, XMLHttpRequest) { ".
            "$('#supervisorsgridview').yiiGridView.update('supervisorsgridview');".
            "$('#supervisor_lookup').val('');}"
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
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl(\'contest/supervisor/member/removeSupervisor\', array(\'memberid\' => $data->primaryKey))',
        ),
    ),
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    'id' => 'supervisorsgridview',
));
?>