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

    $("#refresh_button").click(function() {
        $(\'#clarificationlistview\').yiiListView.update(\'clarificationlistview\');
        $(".content").hide();
        return false;
    });
');?>
<br/>
<div class="spacer"></div>
<a id="refresh_button" href="">Segarkan</a>
<div id="clarification-list-wrapper">
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