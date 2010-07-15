<?php $this->renderPartial('_menu'); ?>
<div>
    <?php echo CHtml::beginForm(); ?>
    <div class="dtable">
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'name'); ?></span>
            <span>
                <?php echo CHtml::activeTextField($model, 'name'); ?>
                <?php echo CHtml::error($model, 'name'); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'description'); ?></span>
            <span>
                <?php echo CHtml::activeTextArea($model, 'description'); ?>
                <?php echo CHtml::error($model, 'description'); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'first_chapter_id'); ?></span>
            <span>
                <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
                  array(
                        'model' => $model,
                        'attribute' => 'first_chapter_id',
                        'sourceUrl' => array('chapterlookup'),
                        'value' => $model->first_chapter_id
                     ));
                ?>
                <?php echo $model->first_chapter->name;?>
            </span>
        </div>
        <div class="drow">
        <span class="shead">Sifat</span>
        <span>
            <?php echo CHtml::activeRadioButtonList($model, 'status', array(
                Training::STATUS_CLOSED => 'Tertutup',
                Training::STATUS_OPEN => 'Terbuka'
            ));?>
        </span>
    </div>
        <div class="drow">
            <span></span>
            <span><?php echo CHtml::submitButton('Simpan');?></span>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
    <hr/>
    <hr/>
</div>