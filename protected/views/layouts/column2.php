<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/arrastheme/layouts/2column.css"); ?>

<?php $this->beginContent('application.views.layouts.main'); ?>
<div id="main-left">
    <?php echo $this->renderPartial('application.views.layouts.sidebars.user'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.main'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.supervisor'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.administrator'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.facebook'); ?>
    <?php //echo $this->renderPartial('application.views.layouts.sidebars.twitter'); ?>
</div><!-- end div#left -->

<div id="main-right">
    <div class="section">
        <div>
            <?php if (!isset($this->needTitle) || $this->needTitle): ?>
                <h2 class="title"><?php echo $this->pageTitle; ?></h2>
            <?php endif; ?>
            <?php echo $content; ?>
            </div>
        </div>
    </div><!-- end div#center -->
<?php $this->endContent(); ?>