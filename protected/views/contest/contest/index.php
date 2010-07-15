<?php $this->setPageTitle("Kontes");?>
<h2 class="title">Kontes </h2>
<div>
    <h4>Kontes yang kamu ikuti</h4>
    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $activeContestDataProvider,
        'itemView' => '_contest',
        'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
        'emptyText' => 'Kamu tidak pernah mengikuti kontes apapun'
    ));
    ?>
</div>