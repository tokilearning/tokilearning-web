<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Bundel Soal </span>
        <span>
    <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
          array(
                'name' => 'problemset_lookup',
                'sourceUrl' => array('problemsetlookup', 'id' => $model->id),
             ));
    ?>
    <?php echo CHtml::ajaxButton('Tambah', $this->createUrl('addproblemset'), array(
        'type' => 'GET',
        'data'=> array(
                "id" => $model->id,
                "problemsetid" => "js:$(\"#problemset_lookup\").val()",
            ),
        'success' => "function(data, textStatus, XMLHttpRequest) {".
        " $('#subproblemsetgridview').yiiGridView.update('subproblemsetgridview');".
        "$('#problemset_lookup').val('');}"
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