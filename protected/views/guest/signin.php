<?php $this->setPageTitle("Masuk");?>
<?php
Yii::app()->clientScript->registerCss('login-form-css', '
    #loginform {padding:5px;display:table;margin:0px 5px 0px 15px;border:1px solid #bbb;}
    #loginform div.row {margin:0px;;display:table-row;}
    #loginform div.row span {display:table-cell;padding:1px 10px;}
    #loginform label {margin:0px;}
    #loginform input {margin:2px;padding:3px;display:}
    #loginform input[type=text],  #loginform input[type=password] {font-size:0.8em;color:#000;}
    #loginform input[type=submit] {padding:3px;color:black;font-weight:bold;cursor:pointer;}
    #loginform a.forgot {}
    #loginform div.errorSummary {margin:5px;padding:5px;border:1px solid #ff0000;color:#000;background:#ffcccc;}
    #loginform div.errorSummary p{font-size:0.8em;margin:0px 0px 0px 0px;}
    #loginform div.errorSummary ul {margin:0px;padding:0px;list-style-position:inside;}
    #loginform div.errorSummary ul li{font-size:0.8em;line-height:15px;}
    #flash-success {margin:5px;padding:5px;border:1px solid #ff0000;color:#000;background:#ffcccc;font-size:0.8em;}
');
?>
<div id="loginform">
    <?php if(Yii::app()->user->hasFlash('register-success')): ?>
    <div id="flash-success">
            Anda sudah terdaftar dalam situs ini. Silahkan masuk.
    </div>
    <?php endif;?>
    <?php echo CHtml::beginForm(); ?>
    <div class="row">
        <span><?php echo CHtml::activeLabel($form, 'username'); ?></span>
        <span><?php echo CHtml::activeTextField($form, 'username') ?></span>
    </div>

    <div class="row">
        <span><?php echo CHtml::activeLabel($form, 'password'); ?></span>
        <span><?php echo CHtml::activePasswordField($form, 'password') ?></span>
    </div>

    <div class="row">
        <span><?php echo CHtml::activeCheckBox($form, 'rememberMe'); ?>
            <?php echo CHtml::activeLabel($form, 'rememberMe'); ?></span>
        <span><?php echo CHtml::submitButton('Masuk'); ?>
            <?php echo CHtml::link('Lupa sandi?', array('guest/forgot'), array('class' => 'forgot')) ?>
        </span>
    </div>
    <div class="row">

    </div>
    <?php echo CHtml::errorSummary($form); ?>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->