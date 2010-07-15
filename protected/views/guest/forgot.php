<?php $this->setPageTitle("Lupa Sandi");?>
<?php
    Yii::app()->clientScript->registerCss('forgot-form-css', '
    #forgot-wrapper {padding:15px;display:table;margin:0px 5px 0px 15px;border:1px solid #bbb;}
    #forgot-wrapper div.row {margin:0px;;display:table-row;}
    #forgot-wrapper div.row span {display:table-cell;padding:1px 10px;}
    #forgot-wrapper label {margin:0px;}
    #forgot-wrapper input {margin:2px;padding:3px;display:}
    #forgot-wrapper input[type=text],  #forgot-wrapper input[type=password] {font-size:0.8em;color:#000;}
    #forgot-wrapper input[type=submit] {padding:3px;color:black;font-weight:bold;cursor:pointer;}
    #forgot-wrapper a.forgot {}
    #forgot-wrapper div.errorSummary {margin:5px;padding:5px;border:1px solid #ff0000;color:#000;background:#ffcccc;}
    #forgot-wrapper div.errorSummary p{font-size:0.8em;margin:0px 0px 0px 0px;}
    #forgot-wrapper div.errorSummary ul {margin:0px;padding:0px;list-style-position:inside;}
    #forgot-wrapper div.errorSummary ul li{font-size:0.8em;line-height:15px;}
    #flash {margin:15px 0px 5px 0px;padding:5px;border:1px solid #ff0000;color:#000;background:#ffcccc;font-size:0.8em;}
    ');
?>
<div id="forgot-wrapper">

    <?php echo CHtml::beginForm(); ?>
    <div>Lupa sandi? Masukkan saja username atau email kamu.</div><br/>
        <?php echo CHtml::textField('forgot');?>
        <?php echo CHtml::submitButton('Kirim'); ?>
    <?php echo CHtml::endForm(); ?>
    
    <?php if (Yii::app()->user->hasFlash('forgot')) : ?>
        <div id="flash">
        <?php if (Yii::app()->user->getFlash('forgot') == 'success') :?>
            Panduan telah dikirim ke email kamu.
        <?php else :?>
            Username atau email tidak ditemukan
        <?php endif;?>
        </div>
    <?php endif; ?>
</div>