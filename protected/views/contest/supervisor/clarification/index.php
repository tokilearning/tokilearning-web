<?php $this->setPageTitle("Klarifikasi");?>
<?php
$contest = $this->getContest();
?>
<?php Yii::app()->clientScript->registerScript('filter-js','
    $(\'#filterbyproblem\').change(function(){
        $(\'#clarificationgridview\').yiiGridView.update(\'clarificationgridview\', {
            url:\'?filterbyproblem=\'+$(this).val()
        });
    });
');?>
<div class="dtable">
    <div class="drow">
        <span class="shead">Saring per Soal</span>
        <span>
        <?php
        $arfilterproblem = array('all' => 'Semua Soal', 'others' => 'Lain-lain');
        $problems = $contest->openproblems;
        foreach($problems as $problem){
            $arfilterproblem[$contest->getProblemAlias($problem)] = $contest->getProblemAlias($problem).". ".$problem->title;
        }
        ?>
        <?php echo CHtml::dropDownList('filterbyproblem', 'all',$arfilterproblem);?>
        </span>
    </div>
</div>
<br/>
<div>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'emptyText' => 'Belum ada klarifikasi',
        'columns' => array(
            'id',
            array(
                'name' => 'problem_id',
                'value' => '($data->problem_id == null)? \'-\' : (CHtml::link($data->problem->title, Yii::app()->controller->createUrl(\'supervisor/problem/view\', array(\'id\' => $data->problem->id))))',
                'type' => 'raw'
            ),
            'subject',
            array(
                'name' => 'questioner_id',
                'value' => '$data->questioner->getFullnameLink()',
                'type' => 'raw'
            ),
            array(
                'name' => 'questioned_time',
                'value' => 'CDateHelper::timespanAbbr($data->questioned_time)',
                'type' => 'raw'
            ),
            array(
                'name' => 'answered_time',
                'value' => 'CDateHelper::timespanAbbr($data->answered_time)',
                'type' => 'raw'
            ),
//            array(
//                'name' => 'status',
//                'value' => '$data->getStatus()'
//            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}'
            )
            
        ),
        'summaryText' => 'Menampilkan {end} pertanyaan dari {count}. ',
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
        'id' => 'clarificationgridview',
        
    ));
    ?>
</div>