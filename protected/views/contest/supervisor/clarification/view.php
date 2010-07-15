<?php $this->setPageTitle("Klarifikasi");?>
<?php
Yii::app()->clientScript->registerCss('clarification-css', '
    #clarification-wrapper, #answer-wrapper {border:1px solid #ccc;padding:5px 15px;margin-bottom:15px;}    
    #clarification-wrapper h2, #answer-wrapper h2 {font-weight:bold;font-size:17px;border-bottom:1px dotted #ccc;margin-bottom:0px;}
    #clarification-wrapper #meta {margin:0px 0px 5px 0px;font-size:10px;}
    #clarification-wrapper p#question {margin:0px 0px 15px 15px;}
');
?>
<?php
Yii::app()->clientScript->registerScript('clarification-js', '
    $(\'#answer_template\').change(function(){
        //alert($(\'#answer\').val());
        switch($(this).val()){
            case \'1\':
				$(\'#answer\').val(\'Ya\');
				break;
			case \'2\':
				$(\'#answer\').val(\'Tidak\');
				break;
			case \'3\':
               	$(\'#answer\').val(\'Tidak ada jawaban\');
                break;
            case \'4\':
                $(\'#answer\').val(\'Sudah pernah dijawab\');
                break;
            case \'5\':
                $(\'#answer\').val(\'Baca soal lebih teliti\');
                break;
        }
    });
');
;?>
<div id="clarification-wrapper" class="article">
    <h2><?php echo $model->subject;?></h2>
    <div class="post-meta">
        Ditanya oleh <?php echo $model->questioner->getFullnameLink();?>,
        <?php echo CDateHelper::timespanAbbr($model->questioned_time);?>,
        
    </div>
    <p id="question">
        <?php echo $model->question;?>
    </p>
</div>
<div id="answer-wrapper" class="article">
    <h2>Jawaban</h2>
    <div>
        <?php if($model->status == Clarification::STATUS_UNANSWERED):?>
            <div class="error">Belum Terjawab</div>
        <?php else:?>
            <div class="post-meta">
                Dijawab oleh <?php echo $model->answerer->getFullnameLink();?>,
                <?php echo CDateHelper::timespanAbbr($model->answered_time);?>
            </div>
        <?php endif;?>
    </div>
    <?php echo CHtml::beginForm($this->createUrl('answer', array('id' => $model->id)));?>
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
                        ), array('id' => 'answer_template'));
                ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead">Jawaban</span>
            <span>
                <?php echo CHtml::error($model, 'answer');?>
                <?php echo CHtml::activeTextArea($model, 'answer', array('id' => 'answer'));?>
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
