<div class="button" style="float:right">
    <?php echo CHtml::link('Perbesar', $this->createUrl('view', array('alias' => $this->getContest()->getProblemAlias($problem), 'view' => 'full')), array('target' => '_blank')); ?>
</div>
<div style="clear:both"></div>
<?php echo ProblemHelper::renderDescription($problem);?>