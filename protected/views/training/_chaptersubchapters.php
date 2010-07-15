<?php if($subchapterDataProvider->totalItemCount > 0):?>
<div id="chapter-list-wrapper">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $subchapterDataProvider,
    'itemView' => '_chapter',   // refers to the partial view named '_post'
    'summaryText' => 'Menampilkan {end} bab dari {count}. ',
    'enableSorting' => false,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/listview/style.css',
));
?>
</div>
<?php endif;?>