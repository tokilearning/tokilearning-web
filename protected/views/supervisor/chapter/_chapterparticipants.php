<?php Yii::app()->clientScript->registerCss('participant-css', '
    .passed {color:#0000ff;font-weight:bold;}
    .working {color:#ff0000;font-weight:bold;}
'); ?>
<?php Yii::app()->clientScript->registerScript('stuffs-css', '
    $(".reset_button").click(function() {
        return confirm("Anda yakin? Aksi ini tidak dapat diulangi");
    });
'); ?>
<?php echo CHtml::beginForm();?>
<?php echo CHtml::activeHiddenField($model, 'id');?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $participant,
        'columns' => array(
            array(
                'class' => 'CCheckBoxColumn',
                'id' => 'mark'
            ),
            array (
                'name' => 'id',
                'value' => '$data->primaryKey',
                'header' => 'ID',
                'sortable' => true
            ),
            array (
                'name' => 'username',
                'value' => '$data->getFullNameLink()',
                'header' => 'Username',
                'sortable' => true,
                'type' => 'raw'
            ),
            array (
                'name' => 'status',
                'value' => '\'<span class=\\\'\'.str_replace(\' \', \'-\', strtolower((Yii::app()->controller->getModel()->isCompleted($data)) ? \'passed\' : \'working\')).\'\\\'>\'.(Yii::app()->controller->getModel()->isCompleted($data) ? \'Lewat\' : \'Aktif\').\'</span>\'',
                'header' => 'Status',
                'sortable' => true,
                'type' => 'raw'
            ),
            array (
                'name' => 'finished_problems',
                'value' => 'Yii::app()->controller->getModel()->getFinishedProblems($data)',
                'header' => 'Soal terselesaikan',
                'sortable' => false,
                'type' => 'raw'
            )
        ),
        'selectableRows' => 30,
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        'id' => 'participantgridview',
    ));

?>
<span>
<?php echo CHtml::ajaxSubmitButton('Kembalikan Peserta', $this->createUrl('resetparticipants'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#participantgridview').yiiGridView.update('participantgridview');}"
    ) , array(
        'class' => 'reset_button'
    )); ?>
</span>
<span>
<?php
echo CHtml::ajaxButton('Kembalikan Semua', $this->createUrl('resetparticipants'), array(
    'type' => 'GET',
    'data' => array(
        "id" => $model->id
    ),
    'success' => "function(data, textStatus, XMLHttpRequest) {" .
    " $('#participantgridview').yiiGridView.update('participantgridview');" .
    "}"
), array(
    'class' => 'reset_button'
));?>
</span>
<?php echo CHtml::endForm();?>