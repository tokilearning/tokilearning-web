<?php $this->setPageTitle("Lupa Sandi");?>

<?php
Yii::app()->clientScript->registerCss('login-form-css', '
    #forgotwrapper {border:1px solid #bbb;padding:10px;text-align:center;}
    #forgotform {padding:5px;display:table;margin:15px auto;text-align:left;border:1px solid #bbb;}
    #forgotform div.row {margin:0px;;display:table-row;}
    #forgotform div.row span {display:table-cell;padding:1px 10px;}
    #forgotform label {margin:0px;}
    #forgotform input {margin:2px;padding:3px;display:}
    #forgotform input[type=text],  #forgotform input[type=password] {font-size:0.8em;color:#000;}
    #forgotform input[type=submit] {padding:3px;color:black;font-weight:bold;cursor:pointer;}
    #flash-success {margin:5px;padding:5px;border:1px solid #ff0000;color:#000;background:#ffcccc;font-size:0.8em;}
');
?>
<div id="forgotwrapper">
    Masukkan username kamu beserta kata kunci yang telah dikirimkan ke email kamu.

<div id="forgotform">
    <?php if(isset($error) && $error): ?>
    <div id="flash-success">
            Username dan kunci tidak ditemukan.
    </div>
    <?php endif;?>
    <?php echo CHtml::beginForm(NULL, 'get'); ?>
    <div class="row">
        <span><?php echo CHtml::label('Username', 'user'); ?></span>
        <span><?php echo CHtml::textField('user', '') ?></span>
    </div>

    <div class="row">
        <span><?php echo CHtml::label('Kunci', 'key'); ?></span>
        <span><?php echo CHtml::textField('key', '') ?></span>
    </div>

    <div class="row">
        <span></span>
        <span>
            <?php echo CHtml::submitButton('Ubah Sandi'); ?>
        </span>
    </div>
    <div class="row">

    </div>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->
</div>