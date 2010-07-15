<br/>
<?php echo CHtml::beginForm();?>
<div>
	<?php echo CHtml::ajaxSubmitButton('Tolak', $this->createUrl('contest/supervisor/member/rejectRegistrants' , array('contestid' => $this->getContest()->id)), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#registrantsgridview').yiiGridView.update('registrantsgridview');}"
    )); ?>
    <?php echo CHtml::ajaxSubmitButton('Terima', $this->createUrl('contest/supervisor/member/approveRegistrants' , array('contestid' => $this->getContest()->id)), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#registrantsgridview').yiiGridView.update('registrantsgridview');$('#contestantsgridview').yiiGridView.update('contestantsgridview');}"
    )); ?>
</div>
<br/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $registrantsDataProvider,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'id' => 'mark'
        ),
        'id',
        'username',
        'full_name',
        'additional_information',
        //'last_activity',
        array(// display a column with "view", "update" and "delete" buttons
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' => $data->primaryKey))',
        )
    ),
    'selectableRows' => 30,
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    'id' => 'registrantsgridview',
));
?>

<div>
	<?php echo CHtml::ajaxSubmitButton('Tolak', $this->createUrl('contest/supervisor/member/rejectRegistrants' , array('contestid' => $this->getContest()->id)), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#registrantsgridview').yiiGridView.update('registrantsgridview');}"
    )); ?>
    <?php echo CHtml::ajaxSubmitButton('Terima', $this->createUrl('contest/supervisor/member/approveRegistrants' , array('contestid' => $this->getContest()->id)), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#registrantsgridview').yiiGridView.update('registrantsgridview');$('#contestantsgridview').yiiGridView.update('contestantsgridview');}"
    )); ?>
</div>
<?php echo CHtml::endForm();?>