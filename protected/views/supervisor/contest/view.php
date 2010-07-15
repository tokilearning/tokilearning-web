<?php $this->setPageTitle("Kontes - ".$contest->name);?>
<?php $this->renderPartial('_menu'); ?>
<?php
Yii::app()->clientScript->registerCss('contest-view-css', '
    #contest-view-wrapper {border:1px solid #bbb;padding:15px;}
    #information-table {display:table;}
    #information-table div.row {display:table-row;}
    #information-table div.row span{display:table-cell;padding:2px 5px;}
    #information-table div.row span.name{font-weight:bold;}
');
$owner = $contest->owner;
$supervisors = $contes->supervisors;
$contestants = $contest->contestants;
?>
<h2 class="title">Kontes</h2>
<div id="contest-view-wrapper">
    <div class="button" style="float:right">
        <?php echo CHtml::link('Masuk', $this->createUrl('contest/contest/signin', array('contestid' => $contest->id))); ?>
    </div>
    <h3><?php echo $contest->name; ?></h3>
    <p><?php echo $contest->description; ?></p>
    <div id="information-table">
        <div class="row">
            <span class="name">Manajer</span>
            <span><?php echo $owner->getFullnameLink() ?></span>
        </div>
        <div class="row">
            <span class="name">Waktu</span>
            <span>
                <?php echo CDateHelper::timespanAbbr($contest->start_time);?> s.d.<br/>
                <?php echo CDateHelper::timespanAbbr($contest->end_time) ?>
                <?php if (strtotime($contest->end_time) < time()): ?><br/>
                    <div class="errorMessage">Kontes ini sudah berakhir</div>
                <?php endif; ?>
                </span>
            </div>
            <div class="row">
                <span class="name">Supervisor</span>
                <span>
                <?php if ($supervisors == null): ?>
                        <em>None</em>
                <?php else: ?>
                            <ol>
                    <?php foreach ($supervisors as $supervisor): ?>
                                <li><?php echo $supervisor->getFullnameLink(); ?></li>
                    <?php endforeach; ?>
                            </ol>
                <?php endif; ?>
                            </span>
                        </div>
                        <div class="row">
                            <span class="name">Kontestan</span>
                            <span>
                <?php if ($contestants == null): ?>
                                    <em>None</em>
                <?php else: ?>
                                        <ol>
                    <?php foreach ($contestants as $contestant): ?>
                                            <li><?php echo $contestant->getFullnameLink(); ?></li>
                    <?php endforeach; ?>
                                        </ol>
                <?php endif; ?>
            </span>
        </div>
        <div class="row">
            <span class="name"></span>
            <span></span>
        </div><div class="row">
            <span class="name"></span>
            <span></span>
        </div>
    </div>
</div>