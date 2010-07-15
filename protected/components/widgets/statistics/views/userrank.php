<?php
Yii::app()->clientScript->registerCss('user_ranks', '
	#user_ranks ul {list-style:none;padding:0px;margin:0px 0px 5px 0px;}
	#user_ranks .update {margin:0px;font-size:11px;text-align:right;}
');
?>
<div class="widget" id="user_ranks">
    <h4 class="widget-title">Lima Besar</h4>
    <div>
	<?php if(isset($ranks) && (count($ranks) > 0)): ?>
		<ul style="display:table">
		<?php foreach($ranks as $r):?>
			<?php $user = User::model()->findByPk($r['id']);?>
			<li style="display:table-row">
				<span style="display:table-cell;padding:0px 6px 0px 0px;"><?php echo $user->getFullnameLink();?></span>
				<span style="display:table-cell">(<?php echo $r['count'];?>)</span>				
			</li>
		<?php endforeach;?>
		</ul>
	<?php endif;?>
	<div class="update">Diperbarui <?php echo CDateHelper::timespanAbbr($update_time);?></div>
    </div>
</div>
