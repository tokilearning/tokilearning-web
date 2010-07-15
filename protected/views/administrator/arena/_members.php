<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Anggota</span>
        <span>
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
                  array(
                        'name' => 'member_lookup',
                        'sourceUrl' => array('administrator/groups/memberlookup'),
                     ));
            ?>
            <?php echo CHtml::ajaxButton('Tambah', $this->createUrl('addmember'), array(
                'type' => 'GET',
                'data'=> array(
                        "id" => $model->id,
                        "memberid"=> "js:$(\"#member_lookup\").val()",
                    ),
                'success' => "function(data, textStatus, XMLHttpRequest) {".
                        "$('#membergridview').yiiGridView.update('membergridview');".
                        "$('#member_lookup').val('');}"
            ));?>
        </span>
    </div>
    <div class="drow">

    </div>
</div>

<div id="member-list-wrapper">
    <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                'id',
                'username',
                'full_name',
                array(// display a column with "view", "update" and "delete" buttons
                    'class' => 'CButtonColumn',
                    'template' => '{view} {delete}',
                    'viewButtonUrl' => 'Yii::app()->controller->createUrl("administrator/user/view",array("id"=>$data->primaryKey))',
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("removemember", array("id" => "'.$model->id.'", "memberid" =>$data->primaryKey))'
                ),
            ),
            'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
            'enablePagination' => true,
            'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
            'id' => 'membergridview'
        ));
?>
</div>