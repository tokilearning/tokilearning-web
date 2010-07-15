<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Bundel Soal </span>
        <span>
    <?php $this->widget('CAutoComplete',
          array(
             'name' => 'problemset_lookup',
             'url' => array('problemsetlookup', 'id' => $model->id),
             'max' => 10,
             'minChars' => 1,
             'delay' => 500,
             'matchCase' => false,
             'htmlOptions' => array('size'=>'30'),
             'methodChain' => ".result(function(event,item){\$(\"#addproblemset_id\").val(item[1]);})",
             ));
    ?>
    <?php echo CHtml::hiddenField('addproblemset_id'); ?>
    <?php echo CHtml::ajaxButton('Tambah', $this->createUrl('addproblemset'), array(
        'type' => 'GET',
        'data'=> array(
                "id" => $model->id,
                "problemsetid" => "js:$(\"#addproblemset_id\").val()",
            ),
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#subproblemsetgridview').yiiGridView.update('subproblemsetgridview');}"
    ));?></span>
    </div>
</div>
<br/>
<?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $subProblemSetDataProvider,
            'columns' => array(
                'id',
                'name',
                array(// display a column with "view", "update" and "delete" buttons
                    'class' => 'CButtonColumn',
                    'template' => '{view} {update} {delete}',
                    'viewButtonUrl' => 'Yii::app()->controller->createUrl("/supervisor/problemset/view", array("id"=>$data->primaryKey))',
                    'updateButtonUrl' => 'Yii::app()->controller->createUrl("/supervisor/problemset/update", array("id"=>$data->primaryKey))',
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("removeproblemset", array("id" => "'.$model->id.'", "problemsetid" =>$data->primaryKey))'
                ),
            ),
            'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
            'enablePagination' => true,
            'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
            'id' => 'subproblemsetgridview'
        ));
?>