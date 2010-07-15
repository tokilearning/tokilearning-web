<?php $this->beginContent('application.views.layouts.guest'); ?>
<div>
    <?php if (!isset($this->needTitle) || $this->needTitle): ?>
        <h2 class="title"><?php echo $this->pageTitle; ?></h2>
    <?php endif; ?>
    <?php echo $content; ?>
    </div>
<?php $this->endContent(); ?>