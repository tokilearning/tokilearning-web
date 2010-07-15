<?php $this->setPageTitle("Sunting Kontes");?>
<?php $this->renderPartial('_menu');?>

<?php echo CHtml::beginForm();?>
<div class="dtable">
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'name');?></span>
        <span><?php echo CHtml::activeTextField($model, 'name');?></span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'description');?></span>
        <span><?php echo CHtml::activeTextArea($model, 'description');?></span>
    </div>
    <div class="drow">
        <span class="shead">Waktu Mulai</span>
        <span>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'=>'startDate',
            // additional javascript options for the date picker plugin
        ));
        ?>
        &nbsp;
        <?php echo CHtml::textField('startTime', 'hh:mm:yy');?>
        </span>
    </div><br/>
    <div class="drow">
        <span class="shead">Waktu Selesai</span>
        <span>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'=>'endDate',
            // additional javascript options for the date picker plugin
        ));
        ?>
        &nbsp;
        <?php echo CHtml::textField('endTime', 'hh:mm:yy');?>
        </span>
    </div><br/>
    <div class="drow">
        <span class="shead">Sifat</span>
        <span>
            <?php echo CHtml::activeRadioButtonList($model, 'status', array(
                Contest::CONTEST_VISIBILITY_HIDDEN => 'Tertutup',
                Contest::CONTEST_VISIBILITY_PUBLIC => 'Terbuka'
            ));?>
        </span>
    </div><br/>
    <div class="drow">
        <span class="shead"></span>
        <span>
            <?php echo CHtml::submitButton('Buat');?>
        </span>
    </div>
</div>
<?php echo CHtml::endForm();?>