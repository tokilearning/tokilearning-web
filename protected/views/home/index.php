<?php $this->setPageTitle("Laman"); ?>
<h2 class="title"><?php echo Yii::t('contest', 'Pengumuman'); ?></h2>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_announcement', // refers to the partial view named '_post'
    'emptyText' => Yii::t('contest', 'Belum ada pengumuman'),
    'summaryText' => Yii::t('contest', 'Menampilkan {end} pengumuman dari {count}.'),
    'enableSorting' => false,
    'cssFile' => Yii::app()->request->baseUrl . '/css/yii/listview/style.css',
));
?>

