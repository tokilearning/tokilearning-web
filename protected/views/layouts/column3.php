<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/arrastheme/layouts/3column.css");?>

<?php $this->beginContent('application.views.layouts.main'); ?>
<div id="main-left">
    <div id="main-center">
</div><!-- end div#center -->
</div><!-- end div#left -->
<div id="main-right">
    <?php echo $content; ?>
</div><!-- end div#center -->
<?php $this->endContent(); ?>