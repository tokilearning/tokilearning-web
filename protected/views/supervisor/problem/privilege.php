<?php $this->setPageTitle("Atur Privilege");?>
<?php $this->renderPartial('_menu');?>
<?php $this->renderPartial('_updateheader', array('model' => $model));?>
<h3>Privilege Soal <?php echo $model->title;?></h3>
<?php if ($model->author->id == Yii::app()->user->id || Group::checkMember("administrator" , Yii::app()->user)) : ?>
<div class="dtable">
    <div class="drow">
        <span class="shead">Tambahkan user ke dalam daftar privilege</span>
        <span>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete',
                    array(
                        'name' => 'supervisor_lookup',
                        'sourceUrl' => array('supervisor/problem/supervisorlookup'),
            ));
            ?>
            <?php
            echo CHtml::ajaxButton('Tambah', $this->createUrl('supervisor/problem/grantprivilege'), array(
                'type' => 'GET',
                'data' => array(
                    "id" => $model->id,
                    "userid" => "js:$(\"#supervisor_lookup\").val()",
                ),
                'success' => "function(data, textStatus, XMLHttpRequest){
                    $('#privilegegridview').yiiGridView.update('privilegegridview');
                    $('#supervisor_lookup').val('');
                }"
            ));
            ?>
                <em>Ketikkan nama atau username untuk mencari supervisor ybs</em>
        </span>
    </div>
</div>
<?php endif;?>
<?php

if ($model->author->id == Yii::app()->user->id || Group::checkMember("administrator" , Yii::app()->user)) {
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'user_id' => array(
                'type' => 'raw',
                'name' => 'User',
                'value' => '$data["username"]'
            ),
            array(// display a column with "view", "update" and "delete" buttons
                'class' => 'CButtonColumn',
                'template' => '{delete}',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl(\'supervisor/problem/revokeprivilege/id/'.$model->id.'\', array(\'userid\' => $data->primaryKey))',
            ),
        ),
        'enablePagination' => false,
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        'id' => 'privilegegridview'
    ));
}
else {
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'user_id' => array(
                'type' => 'raw',
                'name' => 'User',
                'value' => '$data["username"]'
            )
        ),
        'enablePagination' => false,
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        'id' => 'privilegegridview'
    ));
}
?>