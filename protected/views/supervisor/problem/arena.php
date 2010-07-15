<?php $this->setPageTitle("Atur Privilege");?>
<?php $this->renderPartial('_menu');?>
<?php $this->renderPartial('_updateheader', array('model' => $model));?>
<h3>Arena</h3>

<?php if ($model->author->id == Yii::app()->user->id || Group::checkMember("administrator" , Yii::app()->user)) : ?>
<div class="dtable">
    <div class="drow">
        <span class="shead">Tambahkan arena ke dalam daftar</span>
        <span>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete',
                    array(
                        'name' => 'arena_lookup',
                        'sourceUrl' => array('supervisor/problem/arenalookup'),
            ));
            ?>
            <?php
            echo CHtml::ajaxButton('Tambah', $this->createUrl('supervisor/problem/addarena'), array(
                'type' => 'GET',
                'data' => array(
                    "id" => $model->id,
                    "arenaid" => "js:$(\"#arena_lookup\").val()",
                ),
                'success' => "function(data, textStatus, XMLHttpRequest){
                    $('#arenagridview').yiiGridView.update('arenagridview');
                    $('#arena_lookup').val('');
                }"
            ));
            ?>
                <em>Ketikkan nama arena untuk mencari</em>
        </span>
    </div>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'arena_id' => array(
                'type' => 'raw',
                'name' => 'Arena',
                'value' => '$data["name"]'
            ),
            array(// display a column with "view", "update" and "delete" buttons
                'class' => 'CButtonColumn',
                'template' => '{delete}',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl(\'supervisor/problem/removearena/id/'.$model->id.'\', array(\'arenaid\' => $data->primaryKey))',
            ),
        ),
        'enablePagination' => false,
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        'id' => 'arenagridview'
    ));
?>
<?php else:?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'arena_id' => array(
                'type' => 'raw',
                'name' => 'Arena',
                'value' => '$data["name"]'
            )
        ),
        'enablePagination' => false,
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        'id' => 'arenagridview'
    ));
?>
<?php endif;?>