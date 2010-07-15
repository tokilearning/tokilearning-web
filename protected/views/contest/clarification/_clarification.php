<?php
Yii::app()->clientScript->registerCss('clarification-view-css', '
    #clarification-list-wrapper .clarification-view {cursor:pointer;border:1px solid #bbb;padding:3px 5px 3px 5px;margin-bottom:10px;}
    #clarification-list-wrapper .clarification-view:hover {border:1px solid #000;}
    #clarification-list-wrapper .clarification-view .post-meta {margin:3px 0px 2px 0px;}
    #clarification-list-wrapper .clarification-view .content {padding:5px;}
    #clarification-list-wrapper .clarification-view .status_unanswered {margin:0px 0px 0px 5px; font-weight:bold;color:red;float:right;}
    #clarification-list-wrapper .clarification-view .status_answered {margin:0px 0px 0px 5px; font-weight:bold;color:blue;float:right;}
    #clarification-list-wrapper .clarification-view .answer {background:#fefefe;border: 1px dotted #bbb;margin:3px 1px 1px 15px;padding:3px 5px;}
');
Yii::app()->clientScript->registerScript('clarification-view-js', '
    $(\'.content\').hide();$(\'.clarification-view\').click(function(){$(this).children(\'.content\').toggle();});
');
?>
<div class="clarification-view article">
    <h3 class="title"><?php echo $data->subject;?></h3>
    <div class="post-meta">
        Ditanyakan oleh <?php echo $data->questioner->getFullnameLink();?>
        <?php echo CDateHelper::timespanAbbr($data->questioned_time);?>
        pada
        <?php if($data->problem_id == null):?>
                Lain-lain
        <?php else:?>
                <?php $problem = Problem::model()->findByPk($data->problem_id);?>
                Soal <a href="<?php echo $this->createUrl('view', array('alias' => $this->getContest()->getProblemAlias($problem)));?>" class="problem-link">
                    <?php echo $this->getContest()->getProblemAlias($problem);?>.
                    <?php echo $problem->title;?>
                </a>
        <?php endif;?>

        <?php if ($data->status == Clarification::STATUS_UNANSWERED):?>
            <span class="status_unanswered">Belum terjawab</span>
        <?php else:?>
            <span class="status_answered">Sudah terjawab</span>
        <?php endif;?>
    </div>
    <div class="content">
        <?php echo $data->question;?>
        <?php if ($data->status == Clarification::STATUS_ANSWERED):?>
        <div class="answer">
            <div class="post-meta">Dijawab pada <?php echo CDateHelper::timespanAbbr($data->answered_time);?></div>
            <div>
                <?php echo $data->answer;?>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>