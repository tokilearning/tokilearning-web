<?php $this->setPageTitle("Lihat Bundel Soal - ".$model->name);?>
<?php $this->renderPartial('_menu'); ?>
<?php
$parent = $model->parent;
$children = $model->children;
$problems = $model->problems;
?>
<div id="problemset-view-wrapper">
    <div class="button" style="float:right">
<?php echo CHtml::link('Edit', $this->createUrl('update', array('id' => $model->id))); ?>
    </div>
    <h3><?php echo $model->name; ?></h3>
    <p><?php echo $model->description; ?></p>
    <div class="dtable">
        <div class="drow">
            <span class="shead">Parent Problem Set</span>
            <span>
<?php if ($parent == null): ?>
                <em>None</em>
<?php else: ?>
                <?php echo CHtml::link($parent->name, $this->createUrl('view', array('id' => $parent->id))); ?>
                <?php endif; ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead">Sub Problem Sets</span>
            <span>
<?php if ($children == null): ?>
                    <em>None</em>
<?php else: ?>
                    <ul style="margin:0px;padding:3px 0px 0px 9px;">
                <?php foreach ($children as $child):?>
                            <li><?php echo CHtml::link($child->name, $this->createUrl('view', array('id' => $child->id))); ?></li>
                        <?php endforeach;?>
                    </ul>
                <?php endif; ?>
                    </span>
                </div>
                <div class="drow">
                    <span class="shead">Problems</span>
                    <span>
                <?php if ($problems == null): ?>
                            <em>None</em>
                <?php else: ?>
                            <ul style="margin:0px;padding:3px 0px 0px 9px;">
                    <?php foreach ($problems as $problem):?>
                                <li><?php echo CHtml::link($problem->title, $this->createUrl('/supervisor/problem/view', array('id' => $problem->id))); ?></li>
                             <?php endforeach;?>
                                </ul>
                <?php endif; ?>
            </span>
        </div>
    </div>
</div>
