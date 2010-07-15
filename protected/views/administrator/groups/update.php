<?php $this->setPageTitle("Sunting Grup Pengguna");?>
<?php $this->renderPartial('_menu'); ?>
<div class="dtable">
    <?php echo CHtml::beginForm();?>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'name');?></span>
        <span><?php echo CHtml::activeTextField($model, 'name');?></span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'description');?></span>
        <span><?php echo CHtml::activeTextArea($model, 'description');?></span>
    </div>
    <div class="drow">
        <span></span>
        <span><?php echo CHtml::submitButton('Simpan');?></span>
    </div>
    <?php echo CHtml::errorSummary($model);?>
    <?php echo CHtml::endForm();?>
</div>
<hr/>
<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Anggota </span>
        <span>
    <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
          array(
                'name' => 'member_lookup',
                'sourceUrl' => array('memberlookup'),
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
    ));?></span>
    </div>
</div>
<div id="member-list-wrapper">
<?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $memberDataProvider,
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