<?php $this->registerFBMeta(CFBWidget::OG_TITLE, $title); ?>
<?php $this->registerFBMeta(CFBWidget::OG_TYPE, "article"); ?>
<?php $this->registerFBMeta(CFBWidget::OG_IMAGE, Yii::app()->request->hostInfo . Yii::app()->request->baseUrl . '/images/logo-toki-60.png'); ?>
<?php $this->registerFBMeta(CFBWidget::OG_URL, Yii::app()->request->hostInfo . Yii::app()->request->requestUri); ?>
<?php $this->registerFBMeta(CFBWidget::OG_DESCRIPTION, $description); ?>
<br/>
<?php echo CHtml::openTag('div', $htmlOptions); ?>
<div id="fb-root"></div>
<?php echo CHtml::openTag('fb:activity', $options); ?>
<?php echo CHtml::closeTag('fb:activity'); ?>
<?php echo CHtml::closeTag('div'); ?>
