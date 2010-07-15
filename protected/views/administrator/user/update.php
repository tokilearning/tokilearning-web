<?php $this->setPageTitle("Sunting Pengguna");?>
<?php $this->renderPartial('_menu'); ?>

<div class="dtable">
    <?php echo CHtml::beginForm(); ?>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'username');?></span>
        <span>
            <?php echo CHtml::activeTextField($model, 'username', array('size' => '30'));?>
            <?php echo CHtml::error($model, 'username');?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'full_name');?></span>
        <span>
            <?php echo CHtml::activeTextField($model, 'full_name', array('size' => '30'));?>
            <?php echo CHtml::error($model, 'full_name');?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'email');?></span>
        <span>
            <?php echo CHtml::activeTextField($model, 'email', array('size' => '30'));?>
            <?php echo CHtml::error($model, 'email');?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'password');?></span>
        <span>
            <?php echo CHtml::activePasswordField($model, 'password', array('size' => '30'));?>
            <?php echo CHtml::error($model, 'password');?>
        </span>
    </div>
    <div class="drow">
        <span></span>
        <span>
            <?php echo CHtml::link('Hapus', $this->createUrl('delete', array('id' => $model->id)),
        array('onclick' => 'return confirm("Are you sure you want to delete this item?");'));?>&nbsp;
            <?php echo CHtml::submitButton('Simpan');?>
        </span>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>