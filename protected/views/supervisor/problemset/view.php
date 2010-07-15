<?php $this->setPageTitle("Lihat Bundel Soal - ".$model->name);?>
<?php $this->renderPartial('_menu'); ?>
<?php
$parent = $model->parent;
$children = $model->children;
$problems = $model->problems;
?>
<h2 class="title">Kontes</h2>
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
                <?php foreach ($children as $child)
                            echo CHtml::link($child->name, $this->createUrl('view', array('id' => $child->id))); ?>
                <?php endif; ?>
                    </span>
                </div>
                <div class="drow">
                    <span class="shead">Problems</span>
                    <span>
<?php if ($problems == null): ?>
                            <em>None</em>
<?php else: ?>
                <?php endif; ?>
            </span>
        </div>
    </div>
</div>