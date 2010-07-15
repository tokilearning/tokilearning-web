<div class="item">
    <?php
    $iconPath = Yii::app()->request->baseUrl . "/images/icons/";
    $ar1 = array('parent' => '/folder-white-16px.png', 'problemset' => '/folder-gray-16px.png', 'problem' => '/file-white-16px.png');
    $ar2 = array('yes' => "/correct-16px.png", 'no' => "/wrong-16px.png");
    $ar3 = array('yes' => 'Accepted', 'no' => 'Belum Accepted');
    $problemsetIconUrl = $iconPath. $ar1[$data['type']];
    ?>
    <span class="icon"><?php echo CHtml::image($problemsetIconUrl, $data['title'])?></span>
    <span class="link"><?php echo CHtml::link($data['title'], $data['url']);?></span>
    <?php if (isset($data['stats'])) :?>
        <?php if (isset($data['stats']['issolved'])):?>
            <span class="stats issolved">
                <?php if(array_key_exists($data['stats']['issolved'], $ar2)):?>
                    <?php echo CHtml::image($iconPath.$ar2[$data['stats']['issolved']], $ar3[$data['stats']['issolved']]);?>
                <?php endif;?>
            </span>
        <?php endif;?>
        <?php if (isset($data['stats']['accepted'])):?>
            <span class="stats countaccepted"><?php echo $data['stats']['accepted'];?></span>
        <?php endif;?>
        <?php if (isset($data['stats']['not_accepted'])):?>
            <span class="stats countnotaccepted"><?php echo $data['stats']['not_accepted'];?></span>
        <?php endif;?>
    <?php endif;?>
            
</div>
