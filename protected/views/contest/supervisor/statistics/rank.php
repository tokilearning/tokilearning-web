<?php $this->setPageTitle("Peringkat");?>
<?php $this->renderPartial('_menu');?>


<?php echo CHtml::link('Download CSV', $this->createUrl('downloadRank'), array('class' => 'linkbutton'));?>
<?php
$columns = array(
    array(
        'name' => 'username',
        'header' => 'Username',
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
foreach($aliases as $alias){
    $columns[] = array(
        'name' => 'P'.$alias
    );
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