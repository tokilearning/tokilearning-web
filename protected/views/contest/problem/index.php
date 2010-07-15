<?php $this->setPageTitle("Soal");?>
<div id="problem-list-wrapper">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_problem',   // refers to the partial view named '_post'
    'emptyText' => 'Belum ada soal',
    'summaryText' => 'Menampilkan {end} soal dari {count}. ',
    'enableSorting' => false,
));
?>
</div>