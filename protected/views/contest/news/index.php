<?php $this->setPageTitle("Pengumuman");?>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_news',   // refers to the partial view named '_post'
    'emptyText' => 'Belum ada pengumuman',
    'summaryText' => 'Menampilkan {end} pengumuman dari {count}. ',
    'enableSorting' => false,
));
?>