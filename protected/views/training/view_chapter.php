<?php $this->renderPartial('_breadcrumb' , array('chapter' => $chapter , 'tid' => $this->training->id));?>
<?php

$tabs = array(
	'description' => array(
		'title' => 'Deskripsi',
		'view' => '_chapterdesc',
		'data' => array('model' => $chapter)
	)	
);

if (count($chapter->subchapters) > 0)
	$tabs['subchapters'] = array(
		'title' => 'Subbab',
		'view' => '_chaptersubchapters',
		'data' => array('subchapterDataProvider' => $subchapterDataProvider)
	);
	
if (count($chapter->problems) > 0)
	$tabs['problems'] = array(
		'title' => 'Soal',
		'view' => '_chapterproblems',
		'data' => array('problemDataProvider' => $problemDataProvider)
	);

$this->widget('CTabView',
        array(
            'tabs' => $tabs,
                /*'clarification' => array(
                    'title' => 'Klarifikasi',
                    'view' => '_chapterclarifications',
                    'data' => array('clarificationDataProvider' => $clarificationDataProvider , 'clarModel' => $clarModel)
                )*/
            'viewData' => $viewData,
            'id' => 'problem-set-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css",
            'activeTab' => (!isset($currtab) ? 'information': $currtab),
        )
);
?>

