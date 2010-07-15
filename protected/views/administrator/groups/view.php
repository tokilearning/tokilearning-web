<?php $this->setPageTitle("Lihat Grup Pengguna - ".$group->id);?>
<?php $this->renderPartial('_menu'); ?>
<?php
    Yii::app()->clientScript->registerCss('group-css','
        #member-list-wrapper {padding:0px 15px;}
    ');
?>
<div>
    <div class="button" style="float:right">
        <?php echo CHtml::link('Edit', $this->createUrl('update', array('id' => $group->id)));?>
    </div>
    <div class="dtable">
        <div class="drow">
            <span class="shead">ID</span>
            <span><?php echo $group->id;?></span>
        </div>
        <div class="drow">
            <span class="shead">Nama</span>
            <span><?php echo $group->name;?></span>
        </div>
        <div class="drow">
            <span class="shead">Deskripsi</span>
            <span><?php echo $group->description;?></span>
        </div>
        <div class="drow">
            <span class="shead">Anggota</span>
            <span></span>
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
                    'template' => '{view}',
                    'viewButtonUrl' => 'Yii::app()->controller->createUrl("/administrator/user/view",array("id"=>$data->primaryKey))'
                ),
            ),
            'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
            'enablePagination' => true,
            'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
        ));
?>
    </div>
</div>