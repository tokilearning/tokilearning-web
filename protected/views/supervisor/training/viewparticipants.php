<?php $this->renderPartial('_training_menu'); ?>
<div class="dtable">
    <div class="drow">
        <span class="shead">Cari peserta</span>
        <span>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete',
                    array(
                        'name' => 'user_lookup',
                        'sourceUrl' => array('supervisor/chapter/userlookup'),
            ));
            ?>
            <?php
            echo CHtml::ajaxButton('Cari', $this->createUrl('supervisor/training/generatereport'), array(
                'type' => 'GET',
                'data' => array(
                    "id" => $model->id,
                    "userid" => "js:$(\"#user_lookup\").val()",
                ),
                'beforeSend' => "function() {
                    $('#status').text('Memuat.... Harap tunggu');
                }",
                'success' => "function(data, textStatus, XMLHttpRequest){
                    $('#status').html(data);
                }"
            ));
            ?>
			<em>Ketikkan nama atau username untuk mencari peserta ybs</em>
		</span>
    </div>
</div>
<div id="status"></div>