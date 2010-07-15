<?php $this->setPageTitle("Jawaban");?>
<?php //$this->renderPartial('_menu');?>
<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            array(
                'name' => 'problem_id',
                'value' => 'CHtml::link($data->problem->title, Yii::app()->controller->createUrl(\'/problem/view\', array(\'id\' => $data->problem_id)))',
                'type' => 'raw'
            ),
            array(
                'name' => 'submitted_time',
                'value' => 'CDateHelper::timespanAbbr($data->submitted_time)',
                'type' => 'raw'
            ),
            array(
                'name' => 'grade_status',
                'value' => '$data->getGradeStatus()'
            ),
            array(
                'name' => 'verdict',
                'value' => '$data->verdict'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'contest/submission/view\', array(\'id\' => $data->id))',
                //'viewButtonOptions' => array('target' => '_blank'),
                'updateButtonOptions' => array('target' => '_blank'),
            )
        ),
        'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'emptyText' => Yii::t('contest', 'Belum ada jawaban yang sudah dikumpulkan'),
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    ));
?>