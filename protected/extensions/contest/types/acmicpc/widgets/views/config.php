<?php
Yii::app()->clientScript->registerScript('ioi2010-config-ui', '

    $("input[name=\'config[token]\']").change(function() {
        if ($(this).attr("checked")) {
            $(".token-config").show();        
        }
        else
            $(".token-config").hide();
    });    
        
    ');
?>

<?php echo CHtml::beginForm(); ?>
<div id="configform">
    <div class="dtable">
        <div class="drow">
            <span class="shead">Waktu beku</span>
            <span>
                <input name="config[freezetime]" type="text" value="<?php echo $contest->getConfig('freezetime'); ?>" /> detik
            </span>
        </div>
    </div>
    <div class="drow">
        <span>
            <input name="config[submit]" type="submit" value="Simpan" />
        </span>
    </div>
</div>
<?php echo CHtml::endForm(); ?>