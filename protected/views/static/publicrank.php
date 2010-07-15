<?php if (true) : ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js");?>
<?php Yii::app()->clientScript->registerScript('reload-js' , "
	$(document).everyTime('60s' , function() {
		window.location.reload();
	});
");?>
<?php
$contest = Contest::model()->findByPK($_GET['id']);

$this->setPageTitle($contest->name);
Yii::import('ext.contest.ContestTypeHandler');
$handler = ContestTypeHandler::getHandler($contest);
$handler->rankViewWidget(array(
    'contest' => $contest
));
?>
<?php else:?>
<?php $this->setPageTitle("Peringkat OSN 2011");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js"); ?>
<?php Yii::app()->clientScript->registerScript('filter-js', '
    $(document).everyTime("10s" , function() {
        $(\'#rankgridview\').yiiGridView.update(\'rankgridview\');
    });

	function revalidateCSS(id , data) {
		$(".rank").each(function() {
			var index = $(this).attr("class").split(" ")[1].split("-")[1];
			if (index <= 5)
				$(this).children("td").css("background-color" , "rgb(217,217,25)");
			else if (index <= 15)
				$(this).children("td").css("background-color" , "rgb(192,192,192)");
			else if (index <= 30)
				$(this).children("td").css("background-color" , "#ffffff");
		});
	}

	revalidateCSS(0,0);
    
'); ?>

<em>Sel dengan (T) menandakan peserta sudah mengetahui nilai resmi juri</em>
<div>
	<!--
	<h3>Update terakhir : <?php echo date("d/M/Y H:i:s" , $timestamp);?></h3>-->
<?php
	$columns = array(
        array(
            'name' => 'rank',
            'header' => 'Rank',
            'value' => '"<span id=\"".$data[\'actualrank\']."\">" . $data[\'rank\'] . "</span>"',
            'sortable' => "yes",
			'type' => 'raw'
        ),
        array(
            'name' => 'username',
            'header' => 'Nama',
            'value' => '"<strong>".$data[\'full_name\']."</strong>"',
            'type' => 'raw'
        ),
		array(
            'name' => 'city',
			'header' => 'Provinsi'
        ),
        /*array(
            'name' => 'full_name',
            'header' => 'Nama',
            'value' => 'CHtml::link($data[\'full_name\'], Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' =>$data[\'id\'] )))',
            'type' => 'raw'
        ),*/
        array(
            'name' => 'total',
            'header' => 'Total',
            'value' => '$data[\'total\']',

        ),
	array(
	    'name' => 'token',
            'header' => Yii::t('contest', 'Token tersisa'),
            'value' => '"<strong>".$data[\'token\']."</strong>"',
            'type' => 'raw'
	),
    );

	foreach ($problems as $alias => $problem) {
        $columns[] = array(
            'name' => 'P' . $alias,
            'header' => $problem,
            'value' => '($data[\'P'.$alias.'\'] == 100) ? "<span style=\"color: #000;\">".$data[\'P'.$alias.'\']."</span>" : "<span style=\"color: #000;\">".$data[\'P'.$alias.'\']."</span>"',
            'type' => 'raw'
        );
    }


	$dataProvider = new CArrayDataProvider($ranking , array(
		'pagination' => array(
			'pageSize' => 100
		)
	));
	$this->widget('zii.widgets.grid.CGridView',
		array(
			'afterAjaxUpdate' => 'revalidateCSS',
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'rowCssClassExpression' => '"rank no-".$data[\'actualrank\']',
			'summaryText' => 'Update terakhir: <strong>' . date("d/M/Y H:i:s" , $timestamp) . "</strong>",
			'template' => '{summary} {pager} <br/> {items} {pager}',
			'enablePagination' => true,
			'id' => 'rankgridview',
			'selectableRows' => 0,
			'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
		)
	);
?>
</div>
<?php endif;?>
