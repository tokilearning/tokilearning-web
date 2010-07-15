<?php $this->setPageTitle("Klarifikasi");?>
<?php
Yii::app()->clientScript->registerCss('clarification-css', '
    #form-link {font-weight:bold;cursor:pointer;}
    .spacer {clear:both;}
    #form-clarification {border:1px solid #bbb;margin:5px 0px 0px 0px;padding:5px 25px 5px 25px;}
    #clarification-list-wrapper {margin-top:20px;}
');
?>
<?php Yii::app()->clientScript->registerScript('clarification-js','
    $(\'#filterbyproblem\').change(function(){
        $(\'#clarificationlistview\').yiiListView.update(\'clarificationlistview\', {
            url:\'?filterbyproblem=\'+$(this).val()
        });

    });

    /*$(document).everyTime(\'10s\',function(i) {
        $(\'#clarificationlistview\').yiiListView.update(\'clarificationlistview\');
    });*/
');?>
<br/>
<div class="spacer"></div>
<div id="clarification-list-wrapper">
    <?php if ($dataProvider->itemCount > 0):?>
    <div class="dtable">
        <div class="drow">
            <span class="shead"><?php echo Yii::t('contest', 'Saring Per Soal');?></span>
            <span>
            <?php
            $arfilterproblem = array('all' => 'Semua Soal', 'others' => 'Lain-lain');
            $problems = $this->getContest()->openproblems;
            foreach($problems as $problem){
                $arfilterproblem[$this->getContest()->getProblemAlias($problem)] = $this->getContest()->getProblemAlias($problem).". ".$problem->title;
            }
            ?>
            <?php echo CHtml::dropDownList('filterbyproblem', 'all',$arfilterproblem);?>
            </span>
        </div>
    </div>
    <?php endif;?>
    <div>
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
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
</div>
