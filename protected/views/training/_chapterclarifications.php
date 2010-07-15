<div id="clarification-list-wrapper">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $clarificationDataProvider,
    'itemView' => '_clarification',   // refers to the partial view named '_post'
    'emptyText' => 'Belum ada klarifikasi',
    'summaryText' => 'Menampilkan {end} pertanyaan dari {count}. ',
    'enableSorting' => false,
    'id' => 'clarificationlistview',
    'afterAjaxUpdate' => 'function(id, data){$(\'.content\').hide();$(\'.clarification-view\').click(function(){$(this).children(\'.content\').toggle();});}',
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/listview/style.css',
));
?>
</div>
<hr />
<?php /*
<strong>Minta Klarifikasi</strong>
<div id="form-clarification">
    <?php echo CHtml::beginForm($this->createUrl('training/'.$this->training->id.'/createclarification/' . $this->chapter->id));?>
    <div class="dtable">
        <div class="drow">
            <span class="shead">Subyek</span>
            <span>
                <?php echo CHtml::activeTextField($clarModel, 'subject', array('size' => '50'));?>
                <?php echo CHtml::error($clarModel, 'subject');?>
            </span>
        </div>
        <div class="drow">
            <span class="shead">Soal</span>
            <?php
            $problems = $this->chapter->problems;
            $select = array('-1' => 'Lain-lain');
            foreach($problems as $problem){
                $select[$problem->id] = $problem->title;
            }
            ?>
            <span>
                <?php echo CHtml::activeDropDownList($clarModel,'problem_id', $select);?>
            </span>
        </div>
        <div class="drow">
            <span class="shead">Pertanyaan</span>
            <span>
                <?php echo CHtml::activeTextArea($clarModel, 'question');?>
                <?php echo CHtml::error($clarModel, 'question');?>
            </span>
        </div>
        <div class="drow">
            <span></span>
            <span><?php echo CHtml::submitButton('Kirim');?></span>
        </div>
    </div>
    <?php echo CHtml::endForm();?>
</div>*/?>