<?php
Yii::app()->clientScript->registerCss('register-form-css', '
    #n {padding:2px 15px;font-size:0.85em;font-weight:bold;}
    .table {padding:2px;display:table;margin:auto;}
    .table div.row {display:table-row;}
    .table div.row span {display:table-cell;padding:1px 3px;}
    .table div.row span.name {text-align:right;}
    .table label {font-size:0.8em;margin:0px;}
    .table input {margin:2px;padding:3px;display:}
    .table input[type=text],  .table input[type=password] {font-size:0.8em;}
    #captcha-wrapper {text-align: center;}
    #captcha-wrapper img {display:block;margin:auto;}
    #submit-wrapper {text-align:center;}
    #submit-wrapper input[type=submit] {font-size:0.8em;padding:3px;color:black;font-weight:bold;cursor:pointer;}
    #error-summary {padding:0px 20px;margin-bottom:5px;}
    #error-summary div.errorSummary {padding:3px 5px;border:1px solid #ff0000;color:#000;background:#ffcccc;}
    #error-summary div.errorSummary p{font-size:0.8em;margin:0px 0px 0px 0px;}
    #error-summary div.errorSummary ul {margin:0px;padding:0px;padding-left:15px;}
    #error-summary div.errorSummary ul li{font-size:0.8em;line-height:15px;}
');

Yii::app()->clientScript->registerScript('register-js', '
    if ($(\'#regHasError\').val() == \'true\'){
        $(\'#loginform\').hide();
        $(\'#testimonials-wrapper\').hide();
    } else {
        $(\'#regform-wrapper\').hide();
    }
    $(\'#signin-button\').click(function(){
        $(\'#regform-wrapper\').toggle(\'fast\');
        $(\'#loginform\').toggle(\'fast\');
        $(\'#testimonials-wrapper\').toggle(\'fast\');
        return false;
    });
');
?>
<div id="n">Belum punya akun? Silakan <?php echo CHtml::linkButton('mendaftar', array('id' => 'signin-button'))?></div>
<?php echo CHtml::hiddenField('regHasError', (($regHasError) ? 'true' : 'false'), array('id' => 'regHasError'));?>
<div id="regform-wrapper">
<?php echo CHtml::beginForm(); ?>
<div id="regform" class="table">
    <div class="row">
        <span class="name"><?php echo CHtml::activeLabel($user, 'full_name'); ?></span>
        <span><?php echo CHtml::activeTextField($user, 'full_name', array('size' => '25')) ?></span>
    </div>
    <div class="row">
        <span class="name"><?php echo CHtml::activeLabel($user, 'username'); ?></span>
        <span><?php echo CHtml::activeTextField($user, 'username', array('size' => '25')) ?></span>
    </div>
    <div class="row">
        <span class="name"><?php echo CHtml::activeLabel($user, 'email'); ?></span>
        <span><?php echo CHtml::activeTextField($user, 'email', array('size' => '25')) ?></span>
    </div>
    <div class="row">
        <span class="name"><?php echo CHtml::activeLabel($user, 'email_repeat'); ?></span>
        <span><?php echo CHtml::activeTextField($user, 'email_repeat', array('size' => '25')) ?></span>
    </div>
    <div class="row">
        <span class="name"><?php echo CHtml::activeLabel($user, 'password'); ?></span>
        <span><?php echo CHtml::activePasswordField($user, 'password', array('size' => '25')) ?></span>
    </div>
    <div class="row">
        <span class="name"><?php echo CHtml::activeLabel($user, 'password_repeat'); ?></span>
        <span><?php echo CHtml::activePasswordField($user, 'password_repeat', array('size' => '25')) ?></span>
    </div>
</div>
<?php if (extension_loaded('gd')): ?>
    <div id="captcha-wrapper">
    <?php $this->widget('CCaptcha'); ?>
</div>
<div class="table">
    <div class="row">
        <span class="name"><?php echo CHtml::activeLabel($user, 'verifyCode'); ?></span>
        <span><?php echo CHtml::activeTextField($user, 'verifyCode'); ?></span>
    </div>
</div>
<?php endif; ?>
    <div id="submit-wrapper">
        <span><?php echo CHtml::submitButton('Register!'); ?></span>
    </div>
    <br/>
    <div id="error-summary"><?php echo CHtml::errorSummary($user); ?></div>
<?php echo CHtml::endForm(); ?>
</div>