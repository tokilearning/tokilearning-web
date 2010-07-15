<?php
if (isset($problemset) && $problemset != null){
    $this->setPageTitle("Bundel Soal - ".$problemset->name);
} else {
    $this->setPageTitle("Bundel Soal");
}

$iconUrl = Yii::app()->request->baseUrl . "/images/icons";
Yii::app()->clientScript->registerCss('problemset_css', '
    ul#problemset-list {border:1px solid #bbb;margin:0px;padding:15px;padding-left:35px;}
    ul#problemset-list li {margin:0px 0px 2px 0px;line-height:22px;}
    ul#problemset-list li:hover{background:#f0f0f0;}
    ul#problemset-list li:hover a {font-weight:bold;}
    ul#problemset-list li a {display:block;color:#000;height:22px;line-height:22px;}
    ul#problemset-list li.parent {list-style-image:url("' . $iconUrl . '/folder-white-16px.png");}
    ul#problemset-list li.problemset {list-style-image:url("' . $iconUrl . '/folder-gray-16px.png");}
    ul#problemset-list li.problem {list-style-image:url("' . $iconUrl . '/file-white-16px.png");}
    #problem-set-desc {}
    #problem-set-desc h3 {margin-bottom:5px;}
    #problem-set-desc #desc {margin-bottom:10px;padding:0px 0px 0px 5px;}
');
?>
<div>
    <h2 class="title">Bundel Soal</h2>
    <p>Silakan merambah bundel-bundel soal yang tersedia untuk dikerjakan.</p>
    <hr/>
    <?php if (isset($problemset) && $problemset != null) :?>
    <div id="problem-set-desc">
        <h3><?php echo $problemset->name;?></h3>
        <div id="desc"><?php echo $problemset->description;?></div>
    </div>
    <?php endif;?>
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => $problemsetmenuitems,
    'id' => 'problemset-list'
));
?>
</div>