<?php $this->setPageTitle("Log"); ?>
<?php $this->renderPartial('_menu'); ?>
<?php Yii::app()->clientScript->registerScript('filter-js', '
    var update_filter = function(){
        $(\'#submissiongridview\').yiiGridView.update(\'submissiongridview\', {
            url:\'?filterproblem=\'+$(\'#filterbyproblem\').val()+\'&filtercontestant=\'+$(\'#filterbycontestant\').val()
        });
    };

	$("#filterbutton").click(function() {
		$(\'#loggridview\').yiiGridView.update(\'loggridview\', {
            url:\'?filtercontestant=\'+$(\'#member_lookup\').val()
        });
	});
');?>

<div>
    Saring log berdasarkan anggota
    <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
          array(
                'name' => 'member_lookup',
                'sourceUrl' => array('contest/supervisor/statistics/memberlookup'),
             ));
    ?>
	<?php
		/*$arfiltercontestant = array('all' => 'Semua Kontestan');
		$contestants = $this->getContest()->contestants;
		foreach ($contestants as $contestant) {
			$arfiltercontestant[$contestant->id] = $contestant->id . ". (" . $contestant->username . ") " . $contestant->full_name;
		}

		$contestants = $this->getContest()->supervisors;
		foreach ($contestants as $contestant) {
			$arfiltercontestant[$contestant->id] = $contestant->id . ". (" . $contestant->username . ") " . $contestant->full_name;
		}

		$contestant = $this->getContest()->owner;
		$arfiltercontestant[$contestant->id] = $contestant->id . ". (" . $contestant->username . ") " . $contestant->full_name;*/
	?>
	<?php //echo CHtml::dropDownList('filterbycontestant', 'all', $arfiltercontestant, array('id' => 'filterbycontestant')); ?>

	<?php echo CHtml::button('Saring', array('id' => 'filterbutton')); ?>
</div>

<?php

$this->widget('zii.widgets.grid.CGridView',
        array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                array(
                    'name' => 'time',
                    'header' => 'Time',
                    'value' => 'CDateHelper::timespanAbbr(date("Y/m/d H:i:s" , $data[\'time\']))',
                    'type' => 'raw'
                ),
                array(
                    'name' => 'actor',
                    'header' => 'Aktor',
                    'value' => 'CHtml::link(User::model()->findByPK($data[\'actor_id\'])->full_name, Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' =>$data[\'actor_id\'] )))',
                    'type' => 'raw'
                ),
                array(
                    'name' => 'action_type',
                    'header' => 'Aksi',
                    'value' => '$data->getActionText()',
                    'type' => 'raw',
                ),
				array(
					'name' => 'log_content',
					'header' => 'Tambahan',
					'value' => 'ContestLog::model()->findByPK($data[\'id\'])->getRemarksText()',
					'type' => 'raw'
				)
            ),
            'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
            'template' => '{summary} {pager} <br/> {items} {pager}',
            'enablePagination' => true,
            'id' => 'loggridview',
            'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        )
);
?>