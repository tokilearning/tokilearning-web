<?php $this->setPageTitle("Konfigurasi Dasar");?>
<?php $this->renderPartial('_menu');?>

<?php Yii::app()->clientScript->registerScript('span-type-select-js',"
	$('input[name=Contest[span_type]]').change(function() {
		if ($(this).val() == ".Contest::CONTEST_SPAN_TYPE_VIRTUAL.") {
			$('#virtual-span-detail').show();
		}
		else
			$('#virtual-span-detail').hide();
	});
");?>

<?php echo CHtml::beginForm();?>
<div>
    <?php echo CHtml::errorSummary($model);?>
</div>
<div class="dtable">
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'name');?></span>
        <span>
            <?php echo CHtml::activeTextField($model, 'name', array('style' => 'width:98%;'));?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'description');?></span>
        <span>
            <?php echo CHtml::activeTextArea($model, 'description');?>
        </span>
    </div>
    <div class="drow">
        <span class="shead">Sifat</span>
        <span>
            <?php echo CHtml::activeDropDownList($model, 'status', Contest::getContestVisibilityStrings());?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'contest_type_id');?></span>
        <span>
            <?php echo CHtml::activeDropDownList($model, 'contest_type_id', ContestType::toArray());?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'start_time');?></span>
        <span>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name'=>'Contest[startDate]',
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fold',
                ),
                'htmlOptions'=>array(
                ),
                'value' => (isset($model->startDate)? $model->startDate : date('m/d/Y'))
            ));
            ?>
            <?php echo CHtml::textField('Contest[startTime]',
                    (isset($model->startTime)? $model->startTime : '00:00')
            );?>
        </span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo CHtml::activeLabel($model, 'end_time');?></span>
        <span>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name'=>'Contest[endDate]',
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fold',
                ),
                'htmlOptions'=>array(
                ),
                'value' => (isset($model->endDate)? $model->endDate : date('m/d/Y'))
            ));
            ?>
            <?php echo CHtml::textField('Contest[endTime]',
                        (isset($model->endTime)? $model->endTime : '23:59')
                    );?>
        </span>
    </div>
	<div class="drow">
		<span class="shead"><?php echo CHtml::activeLabel($model, 'span_type');?></span>
		<span>
			<?php echo CHtml::activeRadioButtonList($model, 'span_type', array(0 => 'Standar' , 1 => 'Virtual'));?>
		</span>
	</div>
    <div class="drow" id="virtual-span-detail" <?php if ($model->span_type != Contest::CONTEST_SPAN_TYPE_VIRTUAL) echo "style=\"display: none;\"";?>>
        <span class="shead">
			Jangka waktu
		</span>
        <span>
			<input type="text" name="timespan" value="<?php echo $model->getConfig('timespan');?>" /> menit
		</span>
    </div>
    <div class="drow">
        <span></span>
        <span><?php echo CHtml::submitButton('Simpan');?></span>
    </div>
</div>
<?php echo CHtml::endForm();?>