<?php $this->setPageTitle("Peringkat"); ?>
<?php
Yii::import('ext.contest.ContestTypeHandler');
$handler = ContestTypeHandler::getHandler($this->getContest());
$handler->rankViewWidget(array(
    'contest' => $this->getContest(),
    //'supervisor' => false
));
?>
<?php if (false) : ?>
<?php
    $dataProvider = new CArrayDataProvider($ranks, array(
                'id' => 'id',
                'sort' => array(
                    'attributes' => array(
                        'total', 'username',
                    ),
                ),
                'pagination' => array(
                    'pageSize' => 20,
                ),
            ));

    $columns = array(
        array(
            'name' => 'username',
            'header' => 'ID',
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
            'value' => '$data[\'total\']'
        )
    );
    $aliases = $this->getContest()->getProblemAliases();
    $statuses = $this->getContest()->getProblemStatuses();
    foreach ($aliases as $problemid => $alias) {
        if ($statuses[$problemid] != Contest::CONTEST_PROBLEM_HIDDEN) {
            $columns[] = array(
                'name' => 'P' . $alias
            );
        }
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
<?php elseif (false) : ?>
<?php $contest = $this->getContest(); ?>
<?php $problems = $contest->nonhiddenproblems; ?>
<?php $aliases = $contest->getProblemAliases(); ?>
<?php
        Yii::app()->clientScript->registerCss('acm-table-css', '
    table#acm_ranktable td.ac {background-color:#00ff00;}
    table#acm_ranktable td.wa {background-color:#ff5555;}
');
?>
        <table id="acm_ranktable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>User</th>
            <?php foreach ($problems as $problem): ?>
                <th colspan="2">P<?php echo $aliases[$problem->id]; ?></th>
            <?php endforeach; ?>
                <th colspan="2">Total</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        <?php foreach ($ranks as $row): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <abbr title="<?php echo $row['submitter_id']; ?>. <?php echo $row['submitter_username']; ?>"><?php echo $row["submitter_full_name"]; ?>
                            </abbr>
                        </td>
            <?php foreach ($problems as $problem): ?>
            <?php $success = $row["problem" . $aliases[$problem->id] . "_accepted"]; ?>
            <?php $trial = $row["problem" . $aliases[$problem->id] . "_trial"]; ?>
                        <td class="<?php echo (($success == 1) ? "ac" : (($trial == 0) ? "" : "wa")); ?>"><?php echo $row["problem" . $aliases[$problem->id] . "_trial"]; ?></td>
                        <td class="<?php echo (($success == 1) ? "ac" : (($trial == 0) ? "" : "wa")); ?>"><?php echo $row["problem" . $aliases[$problem->id] . "_submitted_time"]; ?></td>
            <?php endforeach; ?>
                        <td><?php echo $row['total_ac']; ?></td>
                        <td><?php echo $row['total_penalty']; ?></td>
                    </tr>
        <?php endforeach; ?>
                    </tbody>
                </table>
<?php endif; ?>
