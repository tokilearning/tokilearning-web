<?php $this->setPageTitle("Soal");?>
<div id="problem-list-wrapper">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_problem',   // refers to the partial view named '_post'
    'emptyText' => Yii::t('contest', 'Belum ada soal'),
    'summaryText' => Yii::t('contest', 'Menampilkan {end} soal dari {count}.'),
    'enableSorting' => false,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/listview/style.css',
));
?>
</div>