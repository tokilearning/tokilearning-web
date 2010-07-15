<?php $this->setPageTitle("TOKI Learning Center"); ?>
<?php
Yii::app()->clientScript->registerMetaTag(Yii::app()->name, NULL, NULL, array('property' => 'og:title'));
Yii::app()->clientScript->registerMetaTag(Yii::app()->name, NULL, NULL, array('property' => 'og:site_name'));
Yii::app()->clientScript->registerMetaTag('website', NULL, NULL, array('property' => 'og:type'));
Yii::app()->clientScript->registerMetaTag(Yii::app()->params->adminEmail, NULL, NULL, array('property' => 'og:email'));
Yii::app()->clientScript->registerMetaTag(Yii::app()->params->facebook['app_id'], NULL, NULL, array('property' =>  'fb:app_id'));
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo . Yii::app()->request->baseUrl . '/images/logo-toki-60.png', NULL, NULL, array('property' => 'og:image'));
?>
<?php
Yii::app()->clientScript->registerCss('guest_home_css', '
    #guest-wrapper {}
    #information-wrapper {width:620px;float:left;}
    #forms-wrapper {width:320px;float:right;padding:0px;}
    #signin-wrapper {border: 1px solid #bbb;margin:0px 5px 5px 5px;padding:3px;}
    #facebook-wrapper {margin:3px 5px 5px 5px;background:#fff;}
    #twitter-wrapper {margin:3px 5px 5px 5px;background:#fff;}
    #register-wrapper {border: 1px solid #bbb;margin:5px;padding:3px;}
    #spacer {clear:both;}
    #welcome, #announcements {border:1px solid #aaa;padding:2px 10px;margin-bottom:15px;}
    #announcements {margin-bottom:0px}
    #welcome h2, #announcements h2 {border-bottom:1px solid #000;}
    #socmed-wrapper {clear:both;padding:0px;margin:0px 5px 7px 5px;}
    #socmed {list-style:none;margin:0px;padding:0px;}
    #socmed li {float:left;}
');
?>
<div id="guest-wrapper">
    <div id="information-wrapper">
        <div id="welcome">
            <h2>Selamat Datang!</h2>
            <p>
                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/logo-toki-158.png', '', array('style' => 'float:right;')); ?>
                Selamat datang di situs <b>TOKI Learning Center</b>. Di situs ini kamu bisa belajar dan berlatih mengerjakan soal-soal pemrograman.
                Soal-soal yang ada di situs ini dikumpulkan dari kegiatan-kegiatan yang dilaksanakan oleh
                <a href="http://www.tokinet.org">Tim Olimpiade Komputer Indonesia.</a>
            </p>
            <p>Situs ini dikembangkan dan dibina oleh <a href="http://toki.if.itb.ac.id">TOKI Biro Institut Teknologi Bandung</a></p>
            <div style="clear:both;"></div>
        </div>
        <div id="announcements">
            <h2>Pengumuman</h2>
            <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_announcement', // refers to the partial view named '_post'
                    'emptyText' => Yii::t('contest', 'Belum ada pengumuman'),
                    'summaryText' => '',
                    'enableSorting' => false,
                    'enablePagination' => false,
                    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/listview/style.css',
                ));
            ?>
            </div>
        </div>

        <div id="forms-wrapper">
            <div id="socmed-wrapper">
            <?php
                $baseUrl = Yii::app()->request->baseUrl . '/images/icons';
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array('label' => CHtml::image($baseUrl . '/twitter-32.png', 'Ikuti kami di Twitter'), 'url' => 'http://twitter.com/tokilearning'),
                        array('label' => CHtml::image($baseUrl . '/facebook-32.png', 'Gabung di Facebook'), 'url' => 'http://www.facebook.com/group.php?gid=166544345960'),
                        array('label' => CHtml::image($baseUrl . '/feed-32.png'), 'url' => array('/feed')),
                    ),
                    'encodeLabel' => false,
                    'htmlOptions' => array('class' => 'menu'),
                    'id' => 'socmed',
                ));
            ?>
                <div style="clear:both;"></div>
            </div>
            <div id="signin-wrapper">
            <?php $this->renderPartial('_loginform', array('loginform' => $loginform)); ?>
            </div>
            <div id="register-wrapper">
            <?php $this->renderPartial('_registerform', array('user' => $user, 'regHasError' => $regHasError)); ?>
            </div>
        <?php if ((!IPChecker::isInITB()) && (!IPChecker::isLocal())): ?>
                    <div id="facebook-wrapper">
                        <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D158291307532266&amp;width=309&amp;colorscheme=light&amp;connections=5&amp;stream=true&amp;header=true&amp;height=230" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:309px; height:230px;" allowTransparency="false"></iframe>
                    </div>
                    <div id="twitter-wrapper">
                        <div class="widget">
                            <script src="http://widgets.twimg.com/j/2/widget.js"></script>
                            <script>
                                new TWTR.Widget({
                                    version: 2,
                                    type: 'profile',
                                    rpp: 5,
                                    interval: 6000,
                                    width: 310,
                                    height: 150,
                                    theme: {
                                        shell: {
                                            background: '#313428',
                                            color: '#ffffff'
                                        },
                                        tweets: {
                                            background: '#f9f9f9',
                                            color: '#5a5a5a',
                                            links: '#000000'
                                        }
                                    },
                                    features: {
                                        scrollbar: true,
                                        loop: false,
                                        live: false,
                                        hashtags: true,
                                        timestamp: true,
                                        avatars: true,
                                        behavior: 'all'
                                    }
                                }).render().setUser('tokilearning').start();
                            </script>
                        </div>
                    </div>
        <?php endif; ?>
    </div>
    <div id="spacer"></div>
</div>
