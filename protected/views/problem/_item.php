<div class="item">
    <?php
    $iconPath = Yii::app()->request->baseUrl . "/images/icons/";
    $ar1 = array('parent' => '/folder-white-16px.png', 'problemset' => '/folder-gray-16px.png', 'problem' => '/file-white-16px.png');
    $ar2 = array('yes' => "/correct-16px.png", 'no' => "/wrong-16px.png");
    $ar3 = array('yes' => 'Accepted', 'no' => 'Belum Accepted');
    $problemIconUrl = $iconPath . "/file-white-16px.png";
    $statistics = StatisticsHandler::instance();
    $problemstat = $statistics->getProblemStat();
    $userstat = $statistics->getUserStat();
    $upidstat = $userstat['users'][Yii::app()->user->id]['problems'];
    if (isset($upidstat)) {
        if (is_array($upidstat['accepted']) && in_array($data->id, $upidstat['accepted'])) {
            $issolved = 'yes';
        } else if (is_array($upidstat['not_accepted']) && in_array($data->id, $upidstat['not_accepted'])) {
            $issolved = 'no';
        } else {
            $issolved = 'nan';
        }
    }
    ?>
    <span class="number">
        <?php echo $widget->dataProvider->pagination->itemCount - ($widget->dataProvider->pagination->currentPage * $widget->dataProvider->pagination->pageSize + $index); ?>
    </span>
    <span class="link">
        <?php echo CHtml::link($data->title, $this->createUrl('problem/view', array('id' => $data->id)),
                array('target' => '_blank', 'title' => $data->description)); ?>
    </span>

    <?php if (isset($issolved)): ?>
            <span class="stats issolved">
        <?php if (array_key_exists($issolved, $ar2)): ?>
        <?php echo CHtml::image($iconPath . $ar2[$issolved], $ar3[$issolved], array('style'=>'margin-top:2px;')); ?>
        <?php endif; ?>
            </span>
    <?php endif; ?>
    <?php $pidstat = $problemstat['problems'][$data->id]; ?>
    <?php if ($pidstat): ?>
                    <span class="stats countaccepted"><?php echo (isset($pidstat['submissions']['accepted']) ? $pidstat['submissions']['accepted'] : 0); ?></span>
                    <span class="stats countnotaccepted"><?php echo (isset($pidstat['submissions']['not_accepted']) ? $pidstat['submissions']['not_accepted'] : 0); ?></span>
    <?php endif; ?>
</div>
