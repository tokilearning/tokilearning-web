<?php $this->setPageTitle("Soal");?>
<?php
    Yii::app()->clientScript->registerCss('button-column-css', '
        #problemsgridview .button-column {width:90px;}
    ');
?>
<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Soal</span>
        <span>
        <?php $this->widget('CAutoComplete',
          array(
             'name' => 'problem_lookup',
             'url' => array('problemlookup'),
             'max' => 10,
             'minChars' => 1,
             'delay' => 500,
             'matchCase' => false,
             'htmlOptions' => array('size'=>'30'),
             'methodChain' => ".result(function(event,item){\$(\"#addproblem_id\").val(item[1]);})",
             ));
        ?>
        <?php echo CHtml::hiddenField('addproblem_id'); ?>
        <?php echo CHtml::ajaxButton('Tambah', $this->createUrl('addproblem'), array(
        'type' => 'GET',
        'data'=> array(
                "problemid"=> "js:$(\"#addproblem_id\").val()",
            ),
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#problemsgridview').yiiGridView.update('problemsgridview');}"
        ));?>
        </span>
    </div>
</div>
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        array(
            'name' => 'alias',
            'value' => 'Yii::app()->controller->getContest()->getProblemAlias($data)'
        ),
        'title',
        array(
            'name' => 'author_id',
            'value' => '$data->author->getFullnameLink()',
            'type' => 'raw'
        ),
        array(
            'name' => 'status',
            'value' => 'Yii::app()->controller->getContest()->getProblemStatusString($data)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}{open}{close}{hide}',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'/supervisor/problem/view\', array(\'id\' => $data->id))',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl(\'/supervisor/problem/update\', array(\'id\' => $data->id))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl(\'removeProblem\', array(\'problemid\' => $data->id))',
            'buttons' => array(
                'open' => array(
                    'label' => 'Open',
                    'url' => 'Yii::app()->controller->createUrl(\'openProblem\', array(\'problemid\' => $data->id))',
                    'visible' => 'Yii::app()->controller->getContest()->getProblemStatus($data) != Contest::CONTEST_PROBLEM_OPEN',
                    'imageUrl' => Yii::app()->request->baseUrl."/images/icons/folder-yellow-open-16px.png",
                ),
                'close' => array(
                    'label' => 'Close',
                    'url' => 'Yii::app()->controller->createUrl(\'closeProblem\', array(\'problemid\' => $data->id))',
                    'visible' => 'Yii::app()->controller->getContest()->getProblemStatus($data) != Contest::CONTEST_PROBLEM_CLOSED',
                    'imageUrl' => Yii::app()->request->baseUrl."/images/icons/lock-16px.png",
                ),
                'hide' => array(
                    'label' => 'Hide',
                    'url' => 'Yii::app()->controller->createUrl(\'hideProblem\', array(\'problemid\' => $data->id))',
                    'visible' => 'Yii::app()->controller->getContest()->getProblemStatus($data) != Contest::CONTEST_PROBLEM_HIDDEN',
                    'imageUrl' => Yii::app()->request->baseUrl."/images/icons/hide-icon-16px.png",
                )
            )
        ),
    ),
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    'id' => 'problemsgridview'
));
?>