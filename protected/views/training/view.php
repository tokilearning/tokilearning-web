<div>
    <?php echo $training->description;?>
</div>
<div id="chapter-list-wrapper">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_chapter',   // refers to the partial view named '_post'
    'emptyText' => 'Belum ada soal/bab',
    'summaryText' => 'Menampilkan {end} bab dari {count}. ',
    'enableSorting' => false,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/listview/style.css',
));
?>
</div>