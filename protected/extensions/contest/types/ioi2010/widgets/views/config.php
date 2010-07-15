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
            <span class="shead">Kontes tertutup</span>
            <span>
                <input name="config[secret]" type="checkbox" <?php if ($contest->getConfig('secret')) echo "checked"; ?> />
            </span>
        </div>
        <div class="drow">
            <span class="shead">Token</span>
            <span>
                <input name="config[token]" type="checkbox" <?php if ($contest->getConfig('token')) echo "checked"; ?> />
            </span>
        </div>
        <div class="drow">
            <span class="shead">Rilis Feedback Lengkap</span>
            <span>
                <input name="config[fullfeedback]" type="checkbox" <?php if ($contest->getConfig('fullfeedback')) echo "checked"; ?> />
                <br />
                <em>Menampilkan hasil grading keseluruhan untuk penggunaan token</em>
            </span>
        </div>
        <div class="drow token-config">
            <span class="shead">Waktu regenerasi (menit)</span>
            <span>
                <input name="config[token_regen]" type="text" value="<?php echo $contest->getConfig('token_regen'); ?>" />
                <br /><em>Kosongkan untuk menonaktifkan regenerasi</em>
            </span>
        </div>
        <div class="drow token-config">
            <span class="shead">Token maksimum</span>
            <span>
                <input name="config[max_token]" type="text" value="<?php echo $contest->getConfig('max_token'); ?>" />
            </span>
        </div>
        <div class="drow">
            <span>
                <input name="config[submit]" type="submit" value="Simpan" />
            </span>
        </div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
