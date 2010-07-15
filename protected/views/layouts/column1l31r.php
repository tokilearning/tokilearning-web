<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/arrastheme/layouts/1l-31rcolumn.css"); ?>

<?php $this->beginContent('application.views.layouts.main'); ?>
<div id="middle">
    <div id="main-left">
        <?php echo $this->renderPartial('application.views.layouts.sidebars.user'); ?>
        <?php echo $this->renderPartial('application.views.layouts.sidebars.main'); ?>
        <?php echo $this->renderPartial('application.views.layouts.sidebars.supervisor'); ?>
        <?php echo $this->renderPartial('application.views.layouts.sidebars.administrator'); ?>
        <?php echo $this->renderPartial('application.views.layouts.sidebars.facebook'); ?>
        <?php echo $this->renderPartial('application.views.layouts.sidebars.twitter'); ?>
    </div><!-- end div#left -->

    <div id="main-right">
        <div id="right-top">
            <div id="right-top-left">
                <?php $this->printWidgets('right-top-left'); ?>
            </div>
            <div id="right-top-middle">
                <?php $this->printWidgets('right-top-middle'); ?>
            </div>
            <div id="right-top-right">
                <?php $this->printWidgets('right-top-right'); ?>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div class="section">
            <div>
                <?php if (!isset($this->needTitle) || $this->needTitle): ?>
                    <h2 class="title"><?php echo $this->pageTitle; ?></h2>
                <?php endif; ?>
                <?php echo $content; ?>
                </div>
            </div>
        </div><!-- end div#center -->
    </div>
<?php $this->endContent(); ?>