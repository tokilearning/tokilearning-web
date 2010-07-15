<?php
Yii::app()->clientScript->registerCss('problem-view-css', '
    #problem-list-wrapper .problem-view {cursor:pointer;border:1px solid #bbb;padding:5px 15px 5px 15px;margin:0px 0px 5px 0px;}
    #problem-list-wrapper .problem-working {border: 1px solid #F50505;}
    #problem-list-wrapper .problem-completed {border: 1px solid #05F505;}
    #problem-list-wrapper .problem-view:hover {border:1px solid #000;}
    #problem-list-wrapper .problem-view h2.title {border-bottom:1px dotted #bbb;font-size:15px;text-decoration:none;}
');
?>
<a href="<?php echo $this->createUrl('training/viewproblem', array('id' => $this->training->id, 'cid' => $this->chapter->id, 'pid' => $data->id));?>" class="problem-link">
<div class="problem-view <?php echo ($this->chapter->isProblemCompleted(Yii::app()->user , $data)) ? "problem-completed" : "problem-working";?>">
    <h2 class="title">
        <?php echo $data->title;?>
    </h2>
</div>
</a>