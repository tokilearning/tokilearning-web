<?php $this->setPageTitle("Buat Pengguna Secara Massal");?>
<?php $this->renderPartial('_menu'); ?>

<?php echo CHtml::beginForm('', 'post', array(
    'onsubmit' => 'return confirm(\'Do you really want to generate users?\')'
));?>
<?php echo CHtml::errorSummary($form);?>
<div class="dtable">
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($form, 'usernamePrefix');?></span>
        <span><?php echo CHtml::activeTextField($form, 'usernamePrefix');?>
        </span>
        <span class="shead"><?php echo CHtml::activeLabel($form, 'usernamePostfix');?></span>
        <span><?php echo CHtml::activeTextField($form, 'usernamePostfix');?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($form, 'digits');?></span>
        <span><?php echo CHtml::activeTextField($form, 'digits');?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($form, 'start');?></span>
        <span><?php echo CHtml::activeTextField($form, 'start');?>
        </span>
        <span class="shead"><?php echo CHtml::activeLabel($form, 'end');?></span>
        <span><?php echo CHtml::activeTextField($form, 'end');?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($form, 'mailDomain');?></span>
        <span><?php echo CHtml::activeTextField($form, 'mailDomain');?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($form, 'mailPrefix');?></span>
        <span><?php echo CHtml::activeTextField($form, 'mailPrefix');?>
        </span>
        <span class="shead"><?php echo CHtml::activeLabel($form, 'mailPostfix');?></span>
        <span><?php echo CHtml::activeTextField($form, 'mailPostfix');?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($form, 'passwordLength');?></span>
        <span><?php echo CHtml::activeTextField($form, 'passwordLength');?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($form, 'uniformPassword');?></span>
        <span><?php echo CHtml::activeCheckBox($form, 'uniformPassword');?>
        </span>
    </div>
    <div class="drow">
        <span></span>
        <span></span>
        <span>
            <?php echo CHtml::submitButton('Buat');?>
        </span>
        <span></span>
    </div>
</div>
<?php echo CHtml::endForm();?>