<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Soal </span>
        <span>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete',
                    array(
                        'name' => 'problem_lookup',
                        'sourceUrl' => array('problemlookup'),
            ));
            ?>
            <?php
            echo CHtml::ajaxButton('Tambah', $this->createUrl('addproblem'), array(
                'type' => 'GET',
                'data' => array(
                    "id" => $model->id,
                    "problemid" => "js:$(\"#problem_lookup\").val()",
                ),
                'success' => "function(data, textStatus, XMLHttpRequest) {" .
                " $('#problemsgridview').yiiGridView.update('problemsgridview');" .
                "$('#problem_lookup').val('');}"
            ));
            ?></span>
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
                        'template' => '{view} {update} {delete} {increaseRank} {decreaseRank}',
                        'viewButtonUrl' => 'Yii::app()->controller->createUrl("supervisor/problem/view",array("id"=>$data->primaryKey))',
                        'updateButtonUrl' => 'Yii::app()->controller->createUrl("supervisor/problem/update",array("id"=>$data->primaryKey))',
                        'deleteButtonUrl' => 'Yii::app()->controller->createUrl("removeproblem", array("id" => "' . $model->id . '", "problemid" =>$data->primaryKey))',
                        'htmlOptions' => array('style' => 'width:100px;'),
                        'buttons' => array(
                            'increaseRank' => array(
                                'label' => 'Increase Rank',
                                'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/down-16px.png",
                                'url' => 'Yii::app()->controller->createUrl("increaserank",array("id" => "' . $model->id . '","pid"=>$data->primaryKey))',
                            ),
                            'decreaseRank' => array(
                                'label' => 'Decrease Rank',
                                'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/up-16px.png",
                                'url' => 'Yii::app()->controller->createUrl("decreaserank",array("id" => "' . $model->id . '","pid"=>$data->primaryKey))',
                            )
                        ),
                    ),
                ),
                'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
                'enablePagination' => true,
                'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
                'id' => 'problemsgridview'
            ));
?>