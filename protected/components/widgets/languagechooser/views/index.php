<div id ="<?php echo $id; ?>" class="login-dd-container flag-dd-c">
	<a class="dark-link login-dd-init flag-dd-i">
		<span style="width: 16px; height:12px; background: url(<?php echo $currentLanguage['image']; ?>) no-repeat left center; display: inline-block;"></span>
		<span class="arrow-down"></span>
	</a>
	<div class="login-dd-content flag-dd-cc">
		<ul class="menu-dd-items flag-dd-items">
			<?php foreach ($languages as $name => $language): ?>
				<?php if ($name != Yii::app()->language) : ?>
					<li><?php echo CHtml::link(CHtml::image($language['image'], $language['title']), '#', array('language' => $name, 'class' => 'flag')); ?></li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>