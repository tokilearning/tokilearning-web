<?php
    Yii::app()->clientScript->registerCss('submit-form' , "
        .submit-form-wrapper {padding: 10px; border: 1px solid #0505F5; margin-bottom: 5px;}
    ");
?>

<?php
    $submitLocked = $this->submitLocked;
    $submitLockedText = $this->submitLockedText;
    $avTokens = $avTokens;
?>
<?php if ($submitLocked):?>
    
<?php else:?>
    <?php if ($submission != null && $submission->hasErrors($answer)) :?>
        <?php echo CHtml::errorSummary($submission);?>
    <?php endif;?>
<div class="submit-form-wrapper">
    <?php echo CHtml::beginForm('?action=submit', 'post', array('enctype' => 'multipart/form-data'));?>
    <div>
        Format berkas kode yang tersedia: <br />
        <ul>
        <?php foreach ($problem->availableLanguages as $ext => $lang) : ?>
        <li><?php echo $lang;?></li>
        <?php endforeach;?>
        </ul>
    </div>
    <div style="display:table">
        <div style="display:table-row">
            <div style="display:table-cell;padding:3px;"><strong>Kode Jawaban</strong></div>
            <div style="display:table-cell;padding:3px;">
                <input type="file" name="Submission[submissionfile]">
                <?php /*
				<?php if ($avTokens > 0) :?>
                <input type="checkbox" name="Submission[fullfeedback]" /> <strong>Minta hasil resmi dengan </strong>
                <?php endif;?>
                <span style="color: #F50505;"><?php echo $avTokens;?> token tersisa</span>*/?>
            </div>
        </div>
    </div>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <input type="submit" name="Submission[submit]" value="Kumpul" />
    <?php echo CHtml::endForm();?>
</div>
<?php endif;?>
<?php
/*$this->widget('CTabView',
        array(
            'tabs' => array(
                'display' => array(
                    'title' => 'Soal',
                    'view' => 'ext.evaluator.types.batchioi2010.widgets.views.problemview.description',
                    'data' => array(
                        'problem' => $problem,
                        'description' => $this->renderDescription(),
                    )
                ),
                'submit' => array(
                    'title' => 'Jawaban',
                    'view' => 'ext.evaluator.types.batchioi2010.widgets.views.problemview.submit',
                    'data' => array(
                        'problem' => $problem,
                        'submission' => $submission,
                        'submitLocked' => $this->submitLocked,
                        'submitLockedText' => $this->submitLockedText,
                        'avTokens' => $avTokens
                    )
                ),
            ),
            'id' => 'problem-update-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css",
            'activeTab' => (isset($action) ? $action : 'display'),
        )
);*/
?>
<div class="button" style="float:right">
    <?php echo CHtml::link('Perbesar', '?action=enlarge', array('target' => '_blank')); ?>
</div>
<div style="clear:both"></div>
<div style="text-align: left;">
<?php echo $this->renderDescription();?>
</div>
<hr />
