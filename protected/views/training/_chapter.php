<?php
Yii::app()->clientScript->registerCss('chapter-view-css', '
    #chapter-list-wrapper .chapter-view {cursor:pointer;border:1px solid #bbb;padding:5px 15px 5px 15px;margin:0px 0px 5px 0px;}
    #chapter-list-wrapper .chapter-view-inaccessible {border:1px solid #bbb;padding:5px 15px 5px 15px;margin:0px 0px 5px 0px;}
    #chapter-list-wrapper .chapter-working {border: 1px solid #F50505;}
    #chapter-list-wrapper .chapter-completed {border: 1px solid #05F505;}
    #chapter-list-wrapper .chapter-view:hover {border:1px solid #000;}
    #chapter-list-wrapper .chapter-view h2.title {border-bottom:1px dotted #bbb;font-size:15px;text-decoration:none;}
    #chapter-list-wrapper .chapter-view-inaccessible h2.title {border-bottom:1px dotted #bbb;font-size:15px;text-decoration:none;}
');
?>
<?php if ($this->training->first_chapter_id == $data->id) :?>
<a href="<?php echo $this->createUrl('training/viewchapter', array('id' => $this->training->id, 'cid' => $data->id));?>" class="chapter-link">
<div class="chapter-view <?php echo ($data->isCompleted(Yii::app()->user)) ? 'chapter-completed' : 'chapter-working'?>">
    <h2 class="title">
        Masuk
    </h2>
</div>
</a>

<?php elseif ($data->isAccessible(Yii::app()->user , $this->training)) : ?>
<a href="<?php echo $this->createUrl('training/viewchapter', array('id' => $this->training->id, 'cid' => $data->id));?>" class="chapter-link">
<div class="chapter-view <?php echo ($data->isCompleted(Yii::app()->user)) ? 'chapter-completed' : 'chapter-working'?>">
    <h2 class="title">
        <?php echo $data->name;?>
    </h2>
</div>
</a>
<?php else:?>
<div class="chapter-view-inaccessible">
    <h2 class="title">
        <?php echo $data->name;?>
    </h2>
</div>
<?php endif;?>
