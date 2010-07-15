<?php
    $sort_attributes = array('total', 'id', 'username');
    $aliases = $contest->getProblemAliases();
    foreach ($aliases as $alias) {
        $sort_attributes[] = 'P' . $alias;
    }
    $dataProvider = new CArrayDataProvider($ranks, array(
                'id' => 'id',
                'sort' => array(
                    'attributes' => $sort_attributes,
                ),
                'pagination' => array(
                    'pageSize' => 20,
                ),
            ));
?>

<?php Yii::app()->clientScript->registerScript('rank-js', '
$("#switchbutton").click(function(){
        var ok = confirm("Do you really want to perform this action? This action can not be UNDONE");
        if (!ok) return false;

        ok = confirm("Are you sure? This is the last warning");
        if (!ok) return false;

        return true;
    });
');
?>

<?php
    if ($supervisor) {
        if (!isset($_GET['mode'])) {
            echo CHtml::link('Full Rank', Yii::app()->controller->createUrl('rank?mode=fullRank'), array('class' => 'linkbutton'));
            echo " ";
            echo CHtml::link('Download CSV', Yii::app()->controller->createUrl('rank?action=downloadCsv'), array('class' => 'linkbutton'));
            echo " ";
            echo CHtml::link('Switch', Yii::app()->controller->createUrl('rank?action=switch'), array('class' => 'linkbutton' , 'id' => 'switchbutton'));
        }
        else {
            echo CHtml::link('Current Rank', Yii::app()->controller->createUrl('rank'), array('class' => 'linkbutton'));
            echo " ";
            echo CHtml::link('Download CSV', Yii::app()->controller->createUrl('rank?mode=fullRank&action=downloadCsv'), array('class' => 'linkbutton'));
            echo " ";
            echo CHtml::link('Switch', Yii::app()->controller->createUrl('rank?mode=fullRank&action=switch'), array('class' => 'linkbutton' , 'id' => 'switchbutton'));
        }
        
    }
?>
<div>
    <?php if ($avTokens > 0) :?>
    <span style="color: #05F505"><?php echo $avTokens;?> </span><?php echo Yii::t('contest', 'token tersisa per');?> <?php echo date("Y-M-d h:i:s");?>
    <?php else :?>
    <span style="color: #F50505"><?php echo Yii::t('contest', 'Tidak ada token tersisa');?></span>
    <?php endif;?>
</div>
<?php
    $columns = array(
        array(
            'name' => 'rank',
            'header' => 'Rank',
            'value' => '$data[\'rank\']',
            'sortable' => "yes"
        ),
        array(
            'name' => 'username',
            'header' => 'Username',
            'value' => '$data[\'username\']'
        ),
        array(
            'name' => 'full_name',
            'header' => 'Nama',
            'value' => 'CHtml::link($data[\'full_name\'], Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' =>$data[\'id\'] )))',
            'type' => 'raw'
        ),
        array(
            'name' => 'total',
            'header' => 'Total',
            'value' => '$data[\'total\']',
            
        )
    );
    $aliases = $contest->getProblemAliases();
    foreach ($aliases as $alias) {
        $columns[] = array(
            'name' => 'P' . $alias,
            'value' => '($data[\'P'.$alias.'\'] == 100) ? "<span style=\"color: #00ff00;\">".$data[\'P'.$alias.'\']."</span>" : "<span style=\"color: #ff5555;\">".$data[\'P'.$alias.'\']."</span>"',
            'type' => 'raw'
        );
    }
    $this->widget('zii.widgets.grid.CGridView',
            array(
                'dataProvider' => $dataProvider,
                'columns' => $columns,
                'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
                'template' => '{summary} {pager} <br/> {items} {pager}',
                'enablePagination' => true,
                'id' => 'evaluatorgridview',
                'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
            )
    );
?>
