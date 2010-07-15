<h3>Lihat Statistik per Soal</h3>
<?php
    $this->widget('zii.widgets.grid.CGridView' , array(
	'dataProvider' => $dataProvider,
	'columns' => array(
	    'id','title',
	    array(
		'class' => 'CButtonColumn',
		'template' => '{downloadStat} {downloadDetail}',
		'buttons' => array(
		    'downloadStat' => array(
			    'label' => 'Unduh Statistik',
			    'imageUrl' => Yii::app()->request->baseUrl."/images/icons/save-16px.png",
			    'url' => 'Yii::app()->controller->createUrl("contest/supervisor/menu" , array("index" => 0, "action" => "download" , "problemid" => $data->id))'
		    ),
		    'downloadDetail' => array(
			    'label' => 'Unduh Rincian',
			    'imageUrl' => Yii::app()->request->baseUrl."/images/icons/down-16px.png",
			    'url' => 'Yii::app()->controller->createUrl("contest/supervisor/menu" , array("index" => 0, "action" => "downloadDetail" , "problemid" => $data->id))'
		    )
		)
	    )
	),
	'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'emptyText' => 'Tidak ada soal isian',
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    ));
?>