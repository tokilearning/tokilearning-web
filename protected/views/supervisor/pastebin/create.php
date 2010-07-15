<?php $this->setPageTitle("Paste Bin");?>
<?php $this->renderPartial('_menu'); ?>

<div>
    <?php echo CHtml::beginForm();?>
    <div class="dtable">
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'type');?></span>
            <span><?php echo CHtml::activeDropDownList($model, 'type', CSyntaxHighlighter::getTypes());?></span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'status');?></span>
            <span><?php echo CHtml::activeDropDownList($model, 'status', PasteBin::getStatusStrings());?></span>
        </div>
    </div>
    <div>
        <strong>Paste</strong>
        <?php echo CHtml::error($model, 'content');?>
        <?php echo CHtml::activeTextArea($model, 'content', array('style' => 'width:100%;'));?>
    </div>
    <div>
        <?php echo CHtml::submitButton('Simpan');?>
    </div>
    <?php echo CHtml::endForm();?>
</div>