<?php
Yii::app()->clientScript->registerCss('item-view-css', '
    #item-list-wrapper .item-view {cursor:pointer;border:1px solid #bbb;padding:5px 15px 5px 15px;margin:0px 0px 5px 0px;}
    #item-list-wrapper .item-view:hover {border:1px solid #000;}
    #item-list-wrapper .item-view h2.title {border-bottom:1px dotted #bbb;font-size:15px;text-decoration:none;}
');
?>
<a href="<?php echo $this->createUrl('training/viewchapter', array('id' => $this->training->id, 'cid' => $data->id));?>" class="item-link">
<div class="item-view">
    <h2 class="title">
        <?php echo $data->name;?>
    </h2>
</div>
</a>