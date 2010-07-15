<?php
    $sort_attributes = array('total', 'id', 'username');
    $aliases = $contest->getProblemAliases();
    foreach ($aliases as $alias) {
        $sort_attributes[] = 'P' . $alias;
    }
    $dataProvider = new CArrayDataProvider($ranks, array(
                'id' => 'id',
                'sort' => array(
                    'attributes' => $sort_attributes,
                ),
                'pagination' => array(
                    'pageSize' => 20,
                ),
            ));
?>

<?php Yii::app()->clientScript->registerScript('rank-js', '
$("#switchbutton").click(function(){
        var ok = confirm("Do you really want to perform this action? This action can not be UNDONE");
        if (!ok) return false;

        ok = confirm("Are you sure? This is the last warning");
        if (!ok) return false;

        return true;
    });
');
?>

<?php
    if ($supervisor) {
        if (!isset($_GET['mode'])) {
            echo CHtml::link('Lihat Nilai Resmi', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank' , array('mode' => 'fullRank' , 'contestid' => $contest->id)), array('class' => 'linkbutton'));
            echo " ";            
            echo CHtml::link('Download CSV', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank' , array('action' => 'downloadCsv')), array('class' => 'linkbutton'));
            echo " ";
            echo CHtml::link('Switch', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank' , array('action' => 'switch')), array('class' => 'linkbutton' , 'id' => 'switchbutton'));
        }
        else {
            echo CHtml::link('Lihat Nilai Sementara', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank'), array('class' => 'linkbutton'));
            echo " ";
            echo CHtml::link('Download CSV', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank' , array('mode' => 'fullRank' , 'action' => 'downloadCsv')), array('class' => 'linkbutton'));
            echo " ";
            echo CHtml::link('Switch', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank' , array('mode' => 'fullRank' , 'action' => 'switch')), array('class' => 'linkbutton' , 'id' => 'switchbutton'));
        }        
    }
?>
<?php
    $columns = array(
		array(
            'name' => 'rank',
            'header' => 'Rank',
            'value' => '$data[\'rank\']',
            'sortable' => "yes"
        ),
        array(
            'name' => 'username',
            'header' => 'Username',
            'value' => '$data[\'username\'] . " (" .  CHtml::link($data[\'full_name\'], Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' =>$data[\'id\'] ))) . ")"',
            'type' => 'raw'
        ),
        array(
            'name' => 'total',
            'header' => 'Total',
            'value' => '$data[\'total\']'
        )
    );
    $aliases = $contest->getProblemAliases();
    foreach ($aliases as $alias) {
        $columns[] = array(
	    'headerHtmlOptions' => array('title' => $contest->getProblemByAlias($alias)->title),
            'name' => 'P' . $alias
        );
    }
?>
<div>
<?php
    $this->widget('zii.widgets.grid.CGridView',
            array(
                'dataProvider' => $dataProvider,
                'columns' => $columns,
                'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
                'template' => '{summary} {pager} <br/> {items} {pager}',
                'enablePagination' => true,
                'id' => 'evaluatorgridview',
                'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
            )
    );
?>
</div>
