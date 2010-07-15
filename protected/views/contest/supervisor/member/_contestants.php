<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Anggota</span>
        <span>
    <?php $this->widget('CAutoComplete',
          array(
             'name' => 'contestant_lookup',
             'url' => array('contestantlookup'),
             'max' => 10,
             'minChars' => 1,
             'delay' => 500,
             'matchCase' => false,
             'htmlOptions' => array('size'=>'30'),
             'methodChain' => ".result(function(event,item){\$(\"#addcontestant_id\").val(item[1]);})",
             ));
    ?>
    <?php echo CHtml::hiddenField('addcontestant_id'); ?>
    <?php echo CHtml::ajaxButton('Tambah', $this->createUrl('addcontestant'), array(
        'type' => 'GET',
        'data'=> array(
                "memberid"=> "js:$(\"#addcontestant_id\").val()",
            ),
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#contestantsgridview').yiiGridView.update('contestantsgridview');}"
    ));?>
        </span>
    </div>
</div>
<br/>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $contestantsDataProvider,
    'columns' => array(
        'id',
        'username',
        'full_name',
        array(// display a column with "view", "update" and "delete" buttons
            'class' => 'CButtonColumn',
            'template' => '{view} {delete}',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' => $data->primaryKey))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl(\'removeContestant\', array(\'memberid\' => $data->primaryKey))',
        ),
    ),
    'template' => '{summary} {items} {pager}',
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    'id' => 'contestantsgridview',
));
?>