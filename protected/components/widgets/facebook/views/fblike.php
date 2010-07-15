<?php $this->registerFBMeta(CFBWidget::OG_TITLE, $title); ?>
<?php $this->registerFBMeta(CFBWidget::OG_TYPE, $type); ?>
<?php $this->registerFBMeta(CFBWidget::OG_IMAGE, Yii::app()->request->hostInfo . Yii::app()->request->baseUrl . '/images/logo-toki-60.png'); ?>
<?php $this->registerFBMeta(CFBWidget::OG_URL, Yii::app()->request->hostInfo . Yii::app()->request->requestUri); ?>
<?php $this->registerFBMeta(CFBWidget::OG_DESCRIPTION, "TOKI Learning Center - " . $title); ?>
<?php echo CHtml::openTag('div', $htmlOptions); ?>
<?php echo CHtml::openTag('fb:like', $options); ?>
<?php echo CHtml::closeTag('fb:like'); ?>
<?php echo CHtml::closeTag('div'); ?>
