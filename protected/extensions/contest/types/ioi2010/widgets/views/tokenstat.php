<?php Yii::app()->clientScript->registerScript('filter-js', '
    var update_filter = function(){
        $(\'#tokengridview\').yiiGridView.update(\'tokengridview\', {
            url:\'?index=0&filterbyproblem=\'+$(\'#filterbyproblem\').val()+\'&filterbycontestant=\'+$(\'#filterbycontestant\').val()
        });
    }

    $(\'#filterbyproblem\').change(update_filter);
    $(\'#filterbutton\').click(update_filter);
'); ?>
<div style="text-align: left">
    <h3>Statistik Token</h3>
    <?php echo CHtml::beginForm(); ?>
    <div class="dtable">
        <div class="drow">
            <span class="shead"><?php echo Yii::t('contest', 'Saring per Soal');?></span>
            <span>
                <?php
                $arfilterproblem = array('all' => 'Semua Soal');
                $problems = $contest->problems;
                foreach ($problems as $problem) {
                    $arfilterproblem[$contest->getProblemAlias($problem)] = $contest->getProblemAlias($problem) . ". " . $problem->title;
                }
                ?>
                <?php echo CHtml::dropDownList('filterbyproblem', 'all', $arfilterproblem, array('id' => 'filterbyproblem')); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead">Saring per Kontestan</span>
            <span>
                <?php
                $arfiltercontestant = array('all' => 'Semua Kontestan');
                $contestants = $contest->contestants;
                foreach ($contestants as $contestant) {
                    $arfiltercontestant[$contestant->id] = $contestant->id . ". (" . $contestant->username . ") " . $contestant->full_name;
                }
                ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'name' => 'filterbycontestant',
                    'sourceUrl' => array('contest/supervisor/member/contestantlookup?contestantfilter=true'),
                ));
                ?>
                <?php //echo CHtml::dropDownList('filterbycontestant', 'all', $arfiltercontestant, array('id' => 'filterbycontestant')); ?>
            </span>
        </div>
        <div class="drow">
            <span><strong>Jumlah</strong></span>
            <span><?php echo CHtml::textField("max-token", "2"); ?></span>
        </div>
        <div class="drow">
            <span>
                <?php echo CHtml::button('Saring', array('id' => 'filterbutton')); ?></span>
            </span>
            <span>
                <?php
                echo CHtml::ajaxSubmitButton('Generate', $this->owner->createUrl('contest/supervisor/menu', array('index' => 0, 'action' => 'ajaxgenerate')), array(
                    'success' => "function(data, response, XMLHttpRequest) { 
                        alert(data);
                        update_filter();
                    }"
                ));
                ?>
            </span>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
    <div>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                array(
                    'name' => 'contestant_id',
                    'value' => '$data->contestant->getFullNameLink()',
                    'type' => 'raw',
                    'header' => 'Contestant'
                ),
                array(
                    'name' => 'problem_id',
                    'value' => '$data->problem->title',
                    'type' => 'raw',
                    'header' => 'Problem'
                ),
                'amount'
            ),
            'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
            'emptyText' => Yii::t('contest', 'Belum ada jawaban yang sudah dikumpulkan'),
            'enablePagination' => true,
            'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
            'id' => 'tokengridview'
        ));
        ?>
    </div>
</div>