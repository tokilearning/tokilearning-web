<?php if ($submitLocked):?>
    <div class="error" style="text-align:center;font-weight:bold;">
        <?php echo $submitLockedText;?>
    </div>
<?php else:?>
    <?php if ($submission != null && $submission->hasErrors($answer)) :?>
        <?php echo CHtml::errorSummary($submission);?>
    <?php endif;?>
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
                    </div>
            </div>
    </div>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <input type="submit" name="Submission[submit]" value="Kumpul" />
    <?php echo CHtml::endForm();?>
<?php endif;?>