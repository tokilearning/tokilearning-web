<?php $this->setPageTitle("TOKI Learning Center");?>
<?php
Yii::app()->clientScript->registerCss('guest_home_css', '
    #guest-wrapper {}
    #information-wrapper {width:530px;float:left;}
    #forms-wrapper {width:320px;float:right;}
    #signin-wrapper {border: 1px solid #bbb;margin:5px;padding:3px;}
    #register-wrapper {border: 1px solid #bbb;margin:5px;padding:3px;}
    #spacer {clear:both;}
');
?>
<div id="guest-wrapper">
    <div id="information-wrapper">
        <h2>Selamat Datang!</h2>
        <p>
            Selamat datang di situs <b>TOKI Learning Center</b>. Di situs ini kamu bisa belajar dan berlatih mengerjakan soal-soal pemrograman.
            Soal-soal yang ada di situs ini dikumpulkan dari kegiatan-kegiatan yang dilaksanakan oleh
            <a href="http://www.tokinet.org">Tim Olimpiade Komputer Indonesia.</a>
        </p>
        <p>Situs ini dikembangkan dan dibina oleh <a href="http://toki.if.itb.ac.id">TOKI Biro Institut Teknologi Bandung</a></p>
    </div>
    <div id="forms-wrapper">
        <div id="signin-wrapper">
            <?php $this->renderPartial('_loginform', array('loginform' => $loginform)); ?>
        </div>
        <div id="register-wrapper">
            <?php $this->renderPartial('_registerform', array('user' => $user)); ?>
        </div>
    </div>
    <div id="spacer"></div>
</div>