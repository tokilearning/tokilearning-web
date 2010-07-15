<?php Yii::app()->clientScript->registerCss('problem_ranks', '
        #problem_ranks ul {list-style:none;padding:0px;margin:0px 0px 5px 0px;display:table;}
	#problem_ranks ul li {display:table-row;}
	#problem_ranks ul li span {display:table-cell;}
        #problem_ranks .update {margin:0px;font-size:11px;text-align:right;}
	#problem_ranks .scount {padding:0px 1px;color:#000;text-align:right;}
	#problem_ranks .saccepted {padding:0px 1px;color:#009300;text-align:right;}
	#problem_ranks .snaccepted {padding:0px 1px;color:#dd0000;text-align:right;}
	
');
?>
<div class="widget" id="problem_ranks">
    <h4 class="widget-title"><?php echo $this->title;?></h4>
    <div>
        <?php if(isset($ranks) && (count($ranks) > 0)): ?>
                <ul>
                <?php foreach($ranks as $r):?>
                        <?php $problem = Problem::model()->findByPk($r['id']);?>
                        <li>
                                <span style="padding:0px 6px 0px 0px;width:100%;">
					 <?php echo CHtml::link($problem->title, Yii::app()->controller->createUrl('/problem/view', array('id' => $problem->id)));?>
				</span>
                                <span class="scount"><?php echo $r['count'];?></span>
				<span class="saccepted"><?php echo $r['accepted'];?></span>
				<span class="snaccepted"><?php echo $r['not_accepted'];?></span>
                        </li>
                <?php endforeach;?>
                </ul>
        <?php endif;?>
        <div class="update">Diperbarui <?php echo CDateHelper::timespanAbbr($update_time);?></div>
    </div>
</div>

