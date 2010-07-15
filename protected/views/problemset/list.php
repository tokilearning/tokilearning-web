<?php
if (isset($problemset) && $problemset != null) {
    $this->setPageTitle("Bundel Soal - " . $problemset->name);
} else {
    $this->setPageTitle("Bundel Soal");
}

$iconUrl = Yii::app()->request->baseUrl . "/images/icons";
Yii::app()->clientScript->registerCss('problemset_css', '
    #problemlist .items {display:table;border:1px solid #bbb;margin:0px;width:96%;padding:15px;}
    #problemlist .items .item {display:table-row;margin:0px 0px 2px 0px;line-height:22px;}
    #problemlist .items .item:hover {background:#f0f0f0;}
    #problemlist .items .item span {display:table-cell;}
    #problemlist .items .item span.icon {width:16px;padding:2px;}
    #problemlist .items .item span.link {padding:0px 3px 0px 5px;width:100%;}
    #problemlist .items .item a {display:block;color:#000;height:22px;line-height:22px;}
    #problemlist .items .item span.stats {padding:0px 2px;text-align:right;}
    #problemlist .items .item span.countaccepted {color:#009300;font-weight:bold;}
    #problemlist .items .item span.countnotaccepted {color:#dd0000;font-weight:bold;}
    #problem-set-desc {}
    #problem-set-desc h3 {margin-bottom:5px;}
    #problem-set-desc #desc {margin-bottom:10px;padding:0px 0px 0px 5px;}
    #problem-path {margin: 10px 0px 4px 0px;border:1px solid #d0d0d0;padding:5px;}
    #problem-path a {text-decoration:none;}
    #problem-path a:hover {text-decoration:underline;}
    #problem-path a#current {text-decoration:underline;}
');
?>
<p>Silakan merambah bundel-bundel soal yang tersedia untuk dikerjakan.</p>
<hr/>
<?php if (isset($problemset) && $problemset != null) : ?>
    <div id="problem-set-desc">
        <h3><?php echo $problemset->name; ?></h3>
        <div id="desc"><?php echo $problemset->description; ?></div>
        <div id="problem-path"><b>Lokasi : </b>
        <?php
        $path = array_reverse($problemset->getPath());
        foreach ($path as $node) {
            echo " / ";
            echo CHtml::link($node['name'], $this->createUrl('list', array('id' => $node['id'])), (($node['id'] == $problemset->id) ? array('id' => 'current') : array()));
        }
        ?>
    </div>
</div>
<?php endif; ?>
        <div>
    <?php
        $arrayDataProvider = new CArrayDataProvider($problemsetitems, array(
                    'pagination' => array(
                        'pageSize' => 30
                    ),
                ));
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $arrayDataProvider,
            'itemView' => '_item',
            'id' => 'problemlist',
            'summaryText' => '',
            'cssFile' => Yii::app()->request->baseUrl . '/css/yii/listview/style.css'
        ));
    ?>
    </div>
    <br/>
<?php //if (true):?>
<?php if ((!IPChecker::isInITB()) && (!IPChecker::isLocal())): ?>
<?php
            $this->widget(
                    'application.components.widgets.facebook.FBLikeWidget',
                    array(
                        'title' => $problemset->name,
                    )
            );
?>
<?php endif; ?>