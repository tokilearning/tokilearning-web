<?php
Yii::app()->clientScript->registerScript('toggle', '
	$(".non-open").hide();

	var filter = function() {
		if ($("#toggle").attr("checked")) {
			$(".non-open").show();
		}
		else
			$(".non-open").hide();
	};

	$("#toggle").change(filter);
');
?>
<h3><?php if ($fullRank)
	echo Yii::t('evaluator', 'Nilai Resmi'); else
	echo Yii::t('evaluator', 'Nilai Sementara'); ?></h3>
<?php
$sort_attributes = array('total', 'id', 'totalOpen', 'username');
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
				'pageSize' => 50,
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
	if (!$fullRank) {
		echo CHtml::link('Lihat Nilai Resmi', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank', array('mode' => 'fullRank', 'contestid' => $contest->id)), array('class' => 'linkbutton'));
		echo " ";
		echo CHtml::link('Download CSV', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank', array('action' => 'downloadCsv')), array('class' => 'linkbutton'));
		//echo " ";
		//echo CHtml::link('Switch', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank', array('action' => 'switch')), array('class' => 'linkbutton', 'id' => 'switchbutton'));
	} else {
		echo CHtml::link('Lihat Nilai Sementara', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank'), array('class' => 'linkbutton'));
		echo " ";
		echo CHtml::link('Download CSV', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank', array('mode' => 'fullRank', 'action' => 'downloadCsv')), array('class' => 'linkbutton'));
		//echo " ";
		//echo CHtml::link('Switch', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank', array('mode' => 'fullRank', 'action' => 'switch')), array('class' => 'linkbutton', 'id' => 'switchbutton'));
	}
	echo " " . CHtml::link('Daftar Peserta', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank', array('action' => 'downloadContestants')), array('class' => 'linkbutton'));
        echo " " . CHtml::link('Clear cache', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank', array('action' => 'clearCache')), array('class' => 'linkbutton'));
}
?>
<div>
	<?php /*
	  <?php if ($avTokens > 0) :?>
	  <span style="color: #05F505"><?php echo $avTokens;?> </span>token tersisa per <?php echo date("Y-M-d h:i:s");?>
	  <?php else :?>
	  <span style="color: #F50505">Tidak ada token tersisa</span>
	  <?php endif;?> */ ?>
</div>

<input type="checkbox" id="toggle" value="non-open" /> <?php echo Yii::t('evaluator', 'Lihat semua');?>

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
			'name' => 'institution',
			'header' => Yii::t('labels', 'Institusi'),
			'value' => '$data["institution"]',
			'sortable' => 'yes'
		),
		/* array(
		  'name' => 'full_name',
		  'header' => 'Nama',
		  'value' => 'CHtml::link($data[\'full_name\'], Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' =>$data[\'id\'] )))',
		  'type' => 'raw'
		  ), */
		array(
			'name' => 'total',
			'header' => 'Total',
			'value' => '$data[\'total\']',
		),
		array(
			'name' => 'totalOpen',
			'header' => 'Subtotal',
			'value' => '$data["totalOpen"]'
		)
	);
	$aliases = $contest->getProblemAliases();
	foreach ($aliases as $alias) {
		$tTrueProblem = $contest->getProblemByAlias($alias);

		$columns[] = array(
			'name' => 'P' . $alias,
			'header' => 'P' . $alias,
			'headerHtmlOptions' => array('title' => $contest->getProblemByAlias($alias)->title, 'class' => ($contest->getProblemStatus($tTrueProblem) != Contest::CONTEST_PROBLEM_OPEN) ? 'non-open' : ''),
			'htmlOptions' => array('title' => $contest->getProblemByAlias($alias)->title, 'class' => ($contest->getProblemStatus($tTrueProblem) != Contest::CONTEST_PROBLEM_OPEN) ? 'non-open' : ''),
			'value' => '($data[\'P' . $alias . '\'] == 100) ? "<span style=\"color: #00ff00;\">".$data[\'P' . $alias . '\']."</span>" : "<span style=\"color: #ff5555;\">".$data[\'P' . $alias . '\']."</span>"',
			'type' => 'raw'
		);
	}
?>

	<div>
	<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider' => $dataProvider,
		'columns' => $columns,
		'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
		'template' => '{summary} {pager} <br/> {items} {pager}',
		'enablePagination' => true,
		'id' => 'evaluatorgridview',
		'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
		'afterAjaxUpdate' => "function(id,data) {
				filter();
			}"
			)
	);
	?>
</div>
