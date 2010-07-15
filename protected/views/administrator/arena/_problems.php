<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Soal</span>
        <span>
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
                  array(
                        'name' => 'problem_lookup',
                        'sourceUrl' => array('problemlookup'),
                     ));
            ?>
            <?php echo CHtml::ajaxButton('Tambah', $this->createUrl('addproblem'), array(
                'type' => 'GET',
                'data'=> array(
                        "id" => $model->id,
                        "problemid"=> "js:$(\"#problem_lookup\").val()",
                    ),
                'success' => "function(data, textStatus, XMLHttpRequest) {".
                        "$('#problemgridview').yiiGridView.update('problemgridview');".
                        "$('#problem_lookup').val('');}"
            ));?>
        </span>
    </div>
    <div class="drow">

    </div>
</div>

<div id="problem-list-wrapper">
    <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                'id',
                'title',
                array(// display a column with "view", "update" and "delete" buttons
                    'class' => 'CButtonColumn',
                    'template' => '{view} {delete}',
                    'viewButtonUrl' => 'Yii::app()->controller->createUrl("supervisor/problem/view",array("id"=>$data->primaryKey))',
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("removeproblem", array("id" => "'.$model->id.'", "problemid" =>$data->primaryKey))'
                ),
            ),
            'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
            'enablePagination' => true,
            'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
            'id' => 'problemgridview'
        ));
?>
</div>