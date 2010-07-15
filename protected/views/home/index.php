<?php $this->setPageTitle("Laman");?>
<h2 class="title">Pengumuman</h2>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_announcement',   // refers to the partial view named '_post'
    'emptyText' => 'Belum ada pengumuman',
    'summaryText' => 'Menampilkan {end} pengumuman dari {count}. ',
    'enableSorting' => false,
));
?>