<h3><?php if ($supervisor) if (isset($_GET['mode'])) echo "Nilai Resmi"; else echo "Nilai Sementara";?></h3>

<?php $problems = $contest->problems; ?>
<?php $aliases = $contest->getProblemAliases(); ?>
<?php
Yii::app()->clientScript->registerCss('acm-table-css', '
    table#acm_ranktable td.ac {background-color:#00ff00;}
    table#acm_ranktable td.wa {background-color:#ff5555;}
');
?>

<?php
    if ($supervisor) {
        if (!isset($_GET['mode'])) {
            echo CHtml::link('Lihat Nilai Resmi', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank' , array('mode' => 'fullrank' , 'contestid' => $contest->id)), array('class' => 'linkbutton'));
        }
        else {
            echo CHtml::link('Lihat Nilai Sementara', Yii::app()->controller->createUrl('contest/supervisor/statistics/rank'), array('class' => 'linkbutton'));
        }
    }
?>

<div>
<table id="acm_ranktable">
    <thead>
        <tr>
            <th>No.</th>
            <th>User</th>
            <th>Username</th>
	    <th>Institusi</th>
    <?php foreach ($problems as $problem): ?>
        <th colspan="2">P<?php echo $aliases[$problem->id]; ?></th>
    <?php endforeach; ?>
        <th colspan="2">Total</th>
    </tr>
</thead>
<tbody>
<?php $i = 1; ?>
<?php foreach ($ranks as $k => $row): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <abbr title="<?php echo $row['submitter_id']; ?>. <?php echo $row['submitter_username']; ?>"><?php echo $row["submitter_full_name"]; ?>
                    </abbr>
                </td>
                <td>
        <?php echo $row['submitter_username']; ?>
        </td>
		<td>
			<?php echo $row['submitter_institution'];?>
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
</div>
