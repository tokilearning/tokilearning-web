<?php
$problems = $problem->getConfig('problems');
for ($i = 1; $i <= count($problems); $i++) {
    $problemidxs[$i] = $i;
}
Yii::app()->clientScript->registerCss('problem-desc-css', '
#problem-wrapper h3 {border-bottom:1px solid #ccc;margin:0px 0px 10px 0px;}
#problem-wrapper h4 {margin:2px 0px;}
#problem-desc-wrapper {padding:10px;border:1px solid #bbb;margin:2px 0px;}
#problem-chooser-wrapper {padding:10px;border:1px solid #bbb;margin:2px 0px;}
');
Yii::app()->clientScript->registerScriptFile($assets . '/problemupdate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('problem-desc-js', '
    var problemcount = ' . count($problems) . ';
    var problems = ' . CJSON::encode($problems) . '
    var problemidx = 1;
', CClientScript::POS_HEAD);
?>


<?php echo CHtml::beginForm('?action=problems'); ?>
<div id="problem-wrapper">
    <div id="problem-chooser-wrapper">
        <h3>Daftar Soal</h3>
        <div>
            <div>
                <?php
                $this->widget('zii.widgets.jui.CJuiSlider', array(
                    'value' => 1,
                    // additional javascript options for the slider plugin
                    'options' => array(
                        'min' => 1,
                        'max' => count($problems),
                        'slide' => 'js:problemchooserslide',
                    ),
                    'htmlOptions' => array(
                    ),
                    'id' => 'problemslider',
                ));
                ?>
            </div>
            <div style="border:1px solid #bbb;display:inline-block;margin:5px 5px 0px 0px;padding:0px 5px;">
                Soal ke <?php echo CHtml::dropDownList('problemchooser', 1, $problemidxs, array('id' => 'problemchooser')); ?>
                dari <span id="problemcount"><?php echo count($problems); ?></span>
                &nbsp;&nbsp;
                <?php echo CHtml::button('<', array('class' => 'backslider')); ?>
<?php echo CHtml::button('>', array('class' => 'nextslider')); ?>
            </div>
            <span>
                <?php echo CHtml::button('Tambah Soal Baru', array('id' => 'newproblembutton')); ?>
<?php echo CHtml::submitButton('Simpan Semua', array('class' => 'submitproblems')); ?>
            </span>
            <div style="font-size:12px;margin:3px 0px;padding:2px;border:1px dotted #ccc;">
                Klik <strong>"Simpan Semua"</strong> untuk menyimpan secara permanen semua soal.
            </div>
        </div>
    </div>
    <div id="problem-desc-wrapper">
        <h3>Detail Soal</h3>
        <div style="text-align:right;">
<?php echo CHtml::button('Hapus Soal Ini', array('class' => 'deleteproblembutton')); ?>
        </div>
        <h4>Pertanyaan</h4>
        <p class="error" style="border: 1px dotted #bbb;padding:0px 5px;">To include image use link "<em>?action=renderviewfile&amp;filename=<strong>filename</strong></em>", where <strong>filename</strong> is a file from view files </p>
        <?php
        $this->widget('ext.ckeditor.CKEditor', array(
            'name' => 'problemquestion',
            'value' => $problems[0]['question'],
            'editorTemplate' => 'advanced',
            'toolbar' => array(
                array('Bold', 'Italic', '-', 'Image', 'Link', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'NumberedList', 'BulletedList', '-', 'Styles', 'Format', '-', 'Source', '-', 'About')
            ),
            'width' => '600px',
            'height' => '100px',
            'id' => 'problemquestion'
        ));
        ?>
        <br/>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jawaban</th>
                    <th>Poin</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="vertical-align: top;">
                        <strong>Utama</strong>
                    </td>
                    <td>
                        <?php echo CHtml::textArea('problemanswer', $problems[0]['answer'], array('style' => 'width:97%;height:100px;', 'id' => 'problemanswer', 'rows' => '4')); ?>
                    </td>
                    <td style="vertical-align: top;">
                <?php echo CHtml::textField('point', $problems[0]['point'], array('id' => 'point')) ?>
                    </td>
                </tr>
<?php for ($i = 0; $i < 5; $i++) : ?>
                    <tr>
                        <td style="vertical-align: top;">
                            <strong>Alternatif <?php echo $i + 1; ?></strong>
                        </td>
                        <td>
                            <?php echo CHtml::textArea('alternatives[' . $i . ']', $problems[0]['alternatives'][$i]['answer'], array('style' => 'width:97%;height:100px;', 'id' => 'alternatives_' . $i, 'rows' => '4')); ?>
                        </td>
                        <td style="vertical-align: top;">
                    <?php echo CHtml::textField('alt_point[' . $i . ']', $problems[0]['alternatives'][$i]['point'], array('id' => 'alt_point_' . $i)) ?>
                        </td>
                    </tr>
<?php endfor; ?>
            </tbody>
        </table>

    </div>
    <div id="problemcontainer">
<?php $i = 0; ?>
        <?php foreach ($problems as $problem): ?>
            <input type="hidden" name="config[problems][<?php echo++$i; ?>][question]" value="<?php echo urlencode($problem['question']); ?>"/>
            <input type="hidden" name="config[problems][<?php echo $i; ?>][answer]" value="<?php echo urlencode($problem['answer']); ?>"/>
            <?php $j = 0; ?>
            <?php if (isset($problem['alternatives'])): ?>
                <?php foreach ($problem['alternatives'] as $alternative): ?>
                    <input type="hidden" name="config[problems][<?php echo $i; ?>][alternatives][<?php echo++$j; ?>]" value="<?php echo $alternative; ?>"/>
                <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    </div>
<?php echo CHtml::submitButton('Simpan Semua', array('class' => 'submitproblems')); ?>
<?php echo CHtml::button('Hapus', array('class' => 'deleteproblembutton')); ?>
</div>
<?php echo CHtml::endForm(); ?>
