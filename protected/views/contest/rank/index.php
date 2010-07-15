<?php $this->setPageTitle("Peringkat");?>

<?php
$columns = array(
    array(
        'name' => 'username',
        'header' => 'ID',
        'value' => '$data[\'username\']'
    ),
    array(
        'name' => 'full_name',
        'header' => 'Nama',
        'value' => 'CHtml::link($data[\'full_name\'], Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' =>$data[\'id\'] )))',
        'type' => 'raw'
    ),
    array(
    'name' => 'total',
    'header' => 'Total',
    'value' => '$data[\'total\']'
    )
);
$aliases = $this->getContest()->getProblemAliases();
$statuses = $this->getContest()->getProblemStatuses();
foreach($aliases as $problemid => $alias){
    if ($statuses[$problemid] != Contest::CONTEST_PROBLEM_HIDDEN) {
        $columns[] = array(
            'name' => 'P'.$alias
        );
    }
}
$this->widget('zii.widgets.grid.CGridView',
        array(
            'dataProvider'=>$dataProvider,
            'columns' => $columns,
            'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
            'template' => '{summary} {pager} <br/> {items} {pager}',
            'enablePagination' => true,
            'id' => 'evaluatorgridview',
            'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        )
    );
?>