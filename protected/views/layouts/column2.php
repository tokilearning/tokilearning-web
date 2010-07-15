<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/arrastheme/layouts/2column.css"); ?>

<?php $this->beginContent('application.views.layouts.main'); ?>
<div id="main-left">
    <?php echo $this->renderPartial('application.views.layouts.sidebars.user'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.main'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.supervisor'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.administrator'); ?>
</div><!-- end div#left -->

<div id="main-right">
    <div class="section">
        <?php echo $content; ?>
    </div>
</div><!-- end div#center -->
<?php $this->endContent(); ?>