<?php
Yii::app()->clientScript->registerCss('problem-view-css', '
    #problem-list-wrapper .problem-view {cursor:pointer;border:1px solid #bbb;padding:5px 15px 5px 15px;}
    #problem-list-wrapper .problem-view:hover {border:1px solid #000;}
    #problem-list-wrapper .problem-view h2.title {border-bottom:1px dotted #bbb;font-size:15px;text-decoration:none;}

');
?>
<a href="<?php echo $this->createUrl('view', array('alias' => $this->getContest()->getProblemAlias($data)));?>" class="problem-link">
<div class="problem-view">
    <h2 class="title">
        <?php echo $this->getContest()->getProblemAlias($data);?>.
        <?php echo $data->title;?>
    </h2>
</div>
</a>