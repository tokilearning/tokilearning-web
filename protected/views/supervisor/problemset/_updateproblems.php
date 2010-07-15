<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Soal </span>
        <span>
    <?php $this->widget('CAutoComplete',
          array(
             'name' => 'problem_lookup',
             'url' => array('problemlookup'),
             'max' => 10,
             'minChars' => 1,
             'delay' => 500,
             'matchCase' => false,
             'htmlOptions' => array('size'=>'30'),
             'methodChain' => ".result(function(event,item){\$(\"#addproblem_id\").val(item[1]);})",
             ));
    ?>
    <?php echo CHtml::hiddenField('addproblem_id'); ?>
    <?php echo CHtml::ajaxButton('Tambah', $this->createUrl('addproblem'), array(
        'type' => 'GET',
        'data'=> array(
                "id" => $model->id,
                "problemid"=> "js:$(\"#addproblem_id\").val()",
            ),
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#problemsgridview').yiiGridView.update('problemsgridview');}"
    ));?></span>
    </div>
</div>
<br/>
<?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $problemsDataProvider,
            'columns' => array(
                'id',
                'title',
                array(// display a column with "view", "update" and "delete" buttons
                    'class' => 'CButtonColumn',
                    'template' => '{view} {update} {delete}',
                    'viewButtonUrl' => 'Yii::app()->controller->createUrl("supervisor/problem/view",array("id"=>$data->primaryKey))',
                    'updateButtonUrl' => 'Yii::app()->controller->createUrl("supervisor/problem/update",array("id"=>$data->primaryKey))',
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("removeproblem", array("id" => "'.$model->id.'", "problemid" =>$data->primaryKey))'
                ),
            ),
            'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
            'enablePagination' => true,
            'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
            'id' => 'problemsgridview'
        ));
?>