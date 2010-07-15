<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Subbab</span>
        <span>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete',
                    array(
                        'name' => 'chapter_lookup',
                        'sourceUrl' => array('orphanchapterlookup?modelid='. $model->id),
            ));
            ?>
            <?php
            echo CHtml::ajaxButton('Tambah', $this->createUrl('addsubchapter'), array(
                'type' => 'GET',
                'data' => array(
                    "id" => $model->id,
                    "subchapterid" => "js:$(\"#chapter_lookup\").val()",
                ),
                'success' => "function(data, textStatus, XMLHttpRequest) {" .
                " $('#problemsgridview').yiiGridView.update('subchaptergridview');" .
                "$('#chapter_lookup').val('');}"
            ));
            ?></span>
    </div>
</div>
<?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider' => $subchapters,
                'columns' => array(
                    'id',
                    'name',
                    array(// display a column with "view", "update" and "delete" buttons
                        'class' => 'CButtonColumn',
                        'template' => '{view} {update} {delete} {increaseOrder} {decreaseOrder}',
                        'viewButtonUrl' => 'Yii::app()->controller->createUrl("supervisor/chapter/view", array("id"=>$data->primaryKey))',
                        'updateButtonUrl' => 'Yii::app()->controller->createUrl("supervisor/chapter/update", array("id"=>$data->primaryKey))',
                        'deleteButtonUrl' => 'Yii::app()->controller->createUrl("supervisor/chapter/delete", array("id"=>$data->primaryKey , "modelid" => '.$model->id.'))',
                        'htmlOptions' => array('style' => 'width:100px;'),
                        'buttons' => array(
                            'increaseOrder' => array(
                                'label' => 'Increase Order',
                                'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/up-16px.png",
                                'url' => 'Yii::app()->controller->createUrl("increaseorder",array("id" => $data->primaryKey , "modelid" => '.$model->id.'))',
                            ),
                            'decreaseOrder' => array(
                                'label' => 'Decrease Order',
                                'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/down-16px.png",
                                'url' => 'Yii::app()->controller->createUrl("decreaseorder",array("id" => $data->primaryKey , "modelid" => '.$model->id.'))',
                            )
                        ),
                    ),
                ),
                'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
                'enablePagination' => true,
                'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
                'id' => 'subchaptergridview'
            ));
?>