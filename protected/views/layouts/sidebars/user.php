<div id="user-widget">
    <div id="name"><?php echo Yii::app()->user->getRecord()->getFullnameLink(); ?></div>
    <div id="avatar">
        <img src="<?php echo Yii::app()->request->baseUrl?>/images/noprofile60.jpg" alt="<?php Yii::app()->user->getRecord()->full_name;?>"/>
    </div>
    <div id="menu">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => Yii::t('menu', 'Sunting Profil'), 'url' => array('/account/setting')),
                array('label' => Yii::t('menu', 'Statistik'), 'url' => array('/account/statistics')),
                array('label' => Yii::t('menu', 'Keluar'), 'url' => array('/account/signout')),
            ),
            'htmlOptions' => array('class' => 'menu')
        ));
        ?>
    </div>
    <div style="clear:both;"></div>
</div>
<!-- -->
<?php
Yii::app()->clientScript->registerCss('guest_home_css', '
	#socmed-wrapper {clear:both;padding:0px;margin:0px 0px 0px 0px;}
	#socmed {list-style:none;margin:0px;padding:0px;}
	#socmed li {float:left;}
');
?>
<div id="socmed-wrapper">
	<?php
	$baseUrl = Yii::app()->request->baseUrl.'/images/icons';
	$this->widget('zii.widgets.CMenu', array(
		'items' => array(
			array('label' => CHtml::image($baseUrl.'/twitter-32.png', Yii::t('menu', 'Ikuti kami di Twitter')), 'url' => 'http://twitter.com/tokilearning'),
			array('label' => CHtml::image($baseUrl.'/facebook-32.png', Yii::t('menu', 'Gabung di Facebook')), 'url' => 'http://www.facebook.com/group.php?gid=166544345960'),
			array('label' => CHtml::image($baseUrl.'/feed-32.png'), 'url' => array('/feed')),
		),
		'encodeLabel' => false,
		'htmlOptions' => array('class' => 'menu'),
		'id' => 'socmed',
	));
	?>
	<div style="clear:both;"></div>
</div>

<!--
<div style="border:1px solid #bbb;background:#fff;margin:0px 0px 15px 0px;padding:5px;color:#ff0000;text-align:center;">
	<a href="http://itbpc.org"><img alt="" src="http://167.205.32.26/itbpc.jpg" style="margin:1px;"/></a>
</div>
-->
