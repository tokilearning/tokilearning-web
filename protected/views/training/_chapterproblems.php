<?php if($problemDataProvider->totalItemCount > 0):?>
<div id="problem-list-wrapper">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $problemDataProvider,
    'itemView' => '_problem',   // refers to the partial view named '_post'
    'summaryText' => 'Menampilkan {end} soal dari {count}. ',
    'enableSorting' => false,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/listview/style.css',
));
?>
</div>
<?php endif;?>