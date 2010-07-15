<?php
Yii::app()->clientScript->registerCss('new_problems', '
        #new_problems ul {list-style:none;padding:0px;margin:0px 0px 5px 0px;}
        #new_problems ul li {display:table-row;}
	#new_problems ul li span {display:table-cell;}
	 #new_problems .update {margin:0px;font-size:11px;text-align:right;}
');
?>
<div class="widget" id="new_problems">
    <h4 class="widget-title">Soal Terbaru</h4>
    <div>
        <?php if (isset($newproblems) && (count($newproblems) > 0)): ?>
            <ul>
			<?php $p = null;?>
            <?php foreach ($newproblems as $problem): ?>
                <li>
                    <span><?php echo CHtml::link($problem->title, Yii::app()->controller->createUrl('/problem/view', array('id' => $problem->id))); ?></span>
                </li>
				<?php $update_time = $problem->created_date;?>
            <?php endforeach; ?>

            </ul>
        <?php endif; ?>
		<div class="update">Diperbarui <?php echo CDateHelper::timespanAbbr($update_time);?></div>
    </div>
</div>
