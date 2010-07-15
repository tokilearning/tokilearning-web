<?php $this->setPageTitle("Tulis Klarifikasi");?>
<div id="form-clarification">
    <?php echo CHtml::beginForm();?>
    <div class="dtable">
        <div class="drow">
            <span class="shead"><?php echo Yii::t('contest', 'Subyek');?></span>
            <span>
                <?php echo CHtml::activeTextField($model, 'subject', array('size' => '50'));?>
                <?php echo CHtml::error($model, 'subject');?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo Yii::t('labels', 'Soal');?></span>
            <?php
            $problems = $this->getContest()->openproblems;
            $select = array('-1' => Yii::t('contest', 'Lain-lain'));
            foreach($problems as $problem){
                $select[$this->getContest()->getProblemAlias($problem)] =
                        $this->getContest()->getProblemAlias($problem). ". ".$problem->title;
            }
            ?>
            <span>
                <?php echo CHtml::dropDownList('problemalias', -1, $select);?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo Yii::t('contest', 'Pertanyaan'); ?></span>
            <span>
                <?php echo CHtml::activeTextArea($model, 'question');?>
                <?php echo CHtml::error($model, 'question');?>
            </span>
        </div>
        <div class="drow">
            <span></span>
            <span><?php echo CHtml::submitButton(Yii::t('contest', 'Kirim'));?></span>
        </div>
    </div>
    <?php echo CHtml::endForm();?>
</div>