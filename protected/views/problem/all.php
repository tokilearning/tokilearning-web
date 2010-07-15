<?php $this->pageTitle = 'Soal-soal'; ?>
<?php

Yii::app()->clientScript->registerCss('problemset_css', '
    #problemlist .items {display:table;border:1px solid #bbb;margin:0px;width:96%;padding:15px;}
    #problemlist .items .item {display:table-row;margin:0px 0px 2px 0px;line-height:22px;}
    #problemlist .items .item:hover {background:#f0f0f0;}
    #problemlist .items .item span {display:table-cell;}
    #problemlist .items .item span.icon {width:16px;padding:2px;}
    #problemlist .items .item span.link {padding:0px 3px 0px 5px;width:100%;}
    #problemlist .items .item a {display:block;color:#000;height:22px;line-height:22px;}
    #problemlist .items .item span.stats {padding:0px 2px;text-align:right;}
    #problemlist .items .item span.countaccepted {color:#009300;font-weight:bold;}
    #problemlist .items .item span.countnotaccepted {color:#dd0000;font-weight:bold;}
    #problemlist .items .item number {width:15px;text-align:right;}
    #problem-set-desc {}
    #problem-set-desc h3 {margin-bottom:5px;}
    #problem-set-desc #desc {margin-bottom:10px;padding:0px 0px 0px 5px;}
    #problem-path {margin: 10px 0px 4px 0px;border:1px solid #d0d0d0;padding:5px;}
    #problem-path a {text-decoration:none;}
    #problem-path a:hover {text-decoration:underline;}
    #problem-path a#current {text-decoration:underline;}
');
?>

<?php if ((!IPChecker::isInITB()) && (!IPChecker::isLocal())): ?>
<?php

    $this->widget(
            'application.components.widgets.facebook.FBLikeWidget',
            array(
                'title' => 'Kumpulan Soal-soal TOKI Learning Center',
                'htmlOptions' => array('style' => 'float:right;'),
                'options' => array('layout' => 'button_count')
            )
    );
?>
<?php endif; ?>

<p style="clear:both;text-align:justify;">Soal-soal di sini adalah semua soal yang tersedia di TOKI Learning Center. 
    Soal-soal ini diurutkan berdasarkan waktu penambahannya. Selamat Mengerjakan!</p>


<?php

    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'id' => 'problemlist',
        'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
		'template' => '{summary} {pager}<br/> {items} {pager}',
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/listview/style.css'
    ));
?>
