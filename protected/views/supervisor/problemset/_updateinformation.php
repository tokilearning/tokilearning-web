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
        <span class="shead"><?php echo CHtml::activeLabel($model, 'status'); ?></span>
        <span>
            <?php echo CHtml::activeDropDownList($model, 'status', ProblemSet::getStatusStrings()); ?>
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
        <span class="shead">Path</span>
        <span>
            <?php
            $path = array_reverse($model->getPath());
            foreach($path as $node){
                echo " / ";
                echo CHtml::link($node['name'], $this->createUrl('update', array('id' => $node['id'])));
            }
            ?>
        </span>
    </div>
    <div class="drow">
        <span></span>
        <span><?php echo CHtml::submitButton('Simpan'); ?></span>
    </div>
</div>
<?php echo CHtml::endForm(); ?>