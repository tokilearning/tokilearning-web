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
    $(\'.content\').hide();
    //$(\'.view\').click(function(){$(this).parent().children(\'.content\').toggle();});
    $(".view").click(function() {
        $(this).parent().children(\'.content\').toggle();
        return false;
    });
');
?>
<script type="text/javascript">
/*$(".view").click(function() {
    $(this).parent().children("content").toggle();
    return false;
});*/
</script>
<div class="clarification-view article">
    <h3 class="title" style="float: left; width: 30%;"><?php echo $data->subject;?></h3>
    <a class="view" href="">Lihat</a>
    <a href="<?php echo $this->createUrl('contest/supervisor/clarification/delete/id/' . $data->id)?>">Hapus</a>
    <div style="clear: both"></div>
    <div class="post-meta">
        Ditanyakan oleh <?php echo $data->questioner->getFullnameLink();?>
        <?php echo CDateHelper::timespanAbbr($data->questioned_time);?>
        pada
        <?php if($data->problem_id == null):?>
                Lain-lain
        <?php else:?>
                <?php $problem = Problem::model()->findByPk($data->problem_id);?>
                Soal <a href="<?php echo $this->createUrl('/contest/problem/view', array('alias' => $this->getContest()->getProblemAlias($problem)));?>" class="problem-link">
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
        <?php echo CHtml::beginForm($this->createUrl('contest/supervisor/clarification/answer', array('id' => $data->id)));?>
    <div class="dtable">
        <div class="drow">
            <span class="shead">Template</span>
            <span>
                <?php echo CHtml::dropDownList('answer_template', 0,
                        array(
                            0 => '',
							1 => 'Yes',
							2 => 'No',
                            3 => 'No Answer',
                            4 => 'Already Answered',
                            5 => 'Read carefully',
                        ), array('id' => 'answer_template_' . $data->id , 'class' => 'ans_template'));
                ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead">Jawaban</span>
            <span>
                <?php echo CHtml::error($data, 'answer');?>
                <?php echo CHtml::activeTextArea($data, 'answer', array('id' => 'answer_' . $data->id));?>
            </span>
        </div>
        <div class="drow">
            <span></span>
            <span>
                <?php echo CHtml::submitButton('Jawab');?>
                <?php echo CHtml::link('Batal', $this->createUrl('index'));?>
            </span>
        </div>
    </div>
    <?php echo CHtml::endForm();?>
    </div>
</div>
