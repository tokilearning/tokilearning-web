<?php $this->setPageTitle("Pengguna");?>
<?php $this->renderPartial('_menu'); ?>

<div>
    <?php echo CHtml::beginForm($this->createUrl('search'), 'get');?>
    <?php echo CHtml::textField('term');?>
    <?php echo CHtml::submitButton('Cari');?>
    <?php echo CHtml::endForm();?>
</div>

<?php if (isset($dataProvider)):?>
<br/>
<?php echo CHtml::beginForm();?>
<?php $searchJSpath = Yii::app()->assetManager->publish(dirname(__FILE__).'/search.js');?>
<?php Yii::app()->clientScript->registerScriptFile($searchJSpath);?>
<?php echo CHtml::submitButton('Delete', array('name' => 'delete', 'id' => 'test'));?>&nbsp;
<?php echo CHtml::submitButton('Generate Passwords', array('name' => 'password', 'id' => 'test'));?>
<br/><br/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
         array(
                'class' => 'CCheckBoxColumn',
                'id' => 'mark'
        ),
        'id',
        'username',
        array(
            'name' => 'full_name',
            'value' => '$data->getFullnameLink()',
            'type' => 'raw'
        ),
        //'join_time',
        array(
            'name' => 'last_login',
            'value' => 'CDateHelper::timespanAbbr($data->last_login)',
            'type' => 'raw'
        ),
        array(// display a column with "view", "update" and "delete" buttons
            'class' => 'CButtonColumn',
        ),
    ),
    'id' => 'usersgridview',
    'summaryText' => 'Menampilkan {count} pengguna.',
    'selectableRows' => 2,
    'enablePagination' => false,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
));
?>
<?php echo CHtml::submitButton('Delete', array('name' => 'delete'));?>&nbsp;
<?php echo CHtml::submitButton('Generate Passwords', array('name' => 'password', 'id' => 'test'));?>
<?php echo CHtml::endForm();?>
<?php endif;?>