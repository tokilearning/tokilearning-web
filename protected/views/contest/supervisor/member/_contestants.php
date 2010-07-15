<div class="dtable">
    <div class="drow">
        <span class="shead">Tambah Anggota</span>
        <span>
    <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
          array(
                'name' => 'contestant_lookup',
                'sourceUrl' => array('contest/supervisor/member/contestantlookup'),
             ));
    ?>
    <?php echo CHtml::ajaxButton('Tambah', $this->createUrl('contest/supervisor/member/addcontestant' , array('contestid' => $this->getContest()->id)), array(
        'type' => 'GET',
        'data'=> array(
                "memberid"=> "js:$(\"#contestant_lookup\").val()",
            ),
        'success' => "function(data, textStatus, XMLHttpRequest) { ".
        "$('#contestantsgridview').yiiGridView.update('contestantsgridview');".
        "$('#contestant_lookup').val('');}"
    ));?>
        </span>
    </div>
</div>

<br/>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $contestantsDataProvider,
    'columns' => array(
        'id',
        'username',
        'full_name',
        'additional_information',
        array(// display a column with "view", "update" and "delete" buttons
            'class' => 'CButtonColumn',
            'template' => '{view} {delete}',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' => $data->primaryKey))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl(\'contest/supervisor/member/removeContestant\', array(\'memberid\' => $data->primaryKey))',
        ),
    ),
    'template' => '{summary} {items} {pager}',
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    'id' => 'contestantsgridview',
));
?>
<h3 style="float: left;">Tambah/Hapus Massal</h3>
<div class="dtable" style="clear: both;">
    <em>Anda dapat menambah atau menghapus anggota secara masal dengan memasukkan aturan penamaan username berikut</em>
    <?php echo CHtml::beginForm();?>
    <div class="drow">
        <span class="shead">Prefix
        </span>
        <span><?php echo CHtml::textField("prefix");?></span>
        <em>Contoh: TOKI001 - TOKI002, prefix : TOKI</em>
    </div>
    <div class="drow">
        <span class="shead">Jumlah Digit</span>
        <span><?php echo CHtml::textField("digit");?></span>
        <em>Contoh: TOKI001 - TOKI002, jumlah digit : 3</em>
    </div>
    <div class="drow">
        <span class="shead">Awal</span>
        <span><?php echo CHtml::textField("start");?></span>
        <em>Contoh: TOKI001 - TOKI002, awal : 1</em>
    </div>
    <div class="drow">
        <span class="shead">Akhir</span>
        <span><?php echo CHtml::textField("end");?></span>
        <em>Contoh: TOKI001 - TOKI002, akhir : 2</em>
    </div>
    <div class="drow">
        <span class="shead">Postfix</span>
        <span><?php echo CHtml::textField("postfix");?>
        </span>
        <em>Contoh: TOKI001a - TOKI002a, postfix : a</em>
    </div>
    <div class="drow">
        <span></span>
        <span>
            <?php echo CHtml::ajaxSubmitButton('Tambah Massal', $this->createUrl('batchAddContestants'), array(
            'success' => "function(data, textStatus, XMLHttpRequest) { $('#contestantsgridview').yiiGridView.update('contestantsgridview');}"
            )); ?>
            <?php echo CHtml::ajaxSubmitButton('Hapus Massal', $this->createUrl('batchRemoveContestants'), array(
                'success' => "function(data, textStatus, XMLHttpRequest) { $('#contestantsgridview').yiiGridView.update('contestantsgridview');}"
            )); ?>
        </span>
    </div>
    <?php echo CHtml::endForm();?>
	<br />
	<hr />
	<h3>Unggah Daftar Peserta</h3>
	<?php echo CHtml::beginForm('' , 'post' , array('enctype' => 'multipart/form-data'));?>
	<div class="dtable">
		<div class="drow">
			<span class="shead">File CSV</span>
			<span><input type="file" name="csvfile" /></span>
		</div>
		<div class="drow">
			<span class="shead">Hapus</span>
			<span><input type="checkbox" name="remove" /></span>
		</div>
		<div class="drow">
			<span class="shead"><input type="submit" value="Unggah" /></span>
		</div>
	</div>
	<?php echo CHtml::endForm();?>
</div>