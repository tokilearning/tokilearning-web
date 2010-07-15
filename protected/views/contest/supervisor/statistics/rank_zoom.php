<?php $this->setPageTitle("Peringkat"); ?>
<?php if ($this->getContest()->contest_type_id == 1) : ?>
<?php
    $dataProvider = new CArrayDataProvider($ranks, array(
                'id' => 'id',
                'sort' => array(
                    'attributes' => array(
                        'total', 'id', 'username',
                    ),
                ),
                'pagination' => array(
                    'pageSize' => 20,
                ),
            ));
?>
<?php echo CHtml::link('Download CSV', $this->createUrl('downloadRank'), array('class' => 'linkbutton')); ?>
<?php
    $columns = array(
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
            'value' => '$data[\'total\']'
        )
    );
    $aliases = $this->getContest()->getProblemAliases();
    foreach ($aliases as $alias) {
        $columns[] = array(
            'name' => 'P' . $alias
        );
    }
    $this->widget('zii.widgets.grid.CGridView',
            array(
                'dataProvider' => $dataProvider,
                'columns' => $columns,
                'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
                'template' => '{summary} {pager} <br/> {items} {pager}',
                'enablePagination' => true,
                'id' => 'evaluatorgridview',
                'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
            )
    );
?>
<?php else: ?>
<?php $contest = $this->getContest(); ?>
<?php $problems = $contest->problems; ?>
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
                        <td class="<?php echo (($success == 1) ? "ac" : "wa"); ?>"><?php echo $row["problem" . $aliases[$problem->id] . "_trial"]; ?></td>
                        <td class="<?php echo (($success == 1) ? "ac" : "wa"); ?>"><?php echo $row["problem" . $aliases[$problem->id] . "_submitted_time"]; ?></td>
            <?php endforeach; ?>
                        <td><?php echo $row['total_ac']; ?></td>
                        <td><?php echo $row['total_penalty']; ?></td>
                    </tr>
        <?php endforeach; ?>
                    </tbody>
                </table>
<?php endif; ?>