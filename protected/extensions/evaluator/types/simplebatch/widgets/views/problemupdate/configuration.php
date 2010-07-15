<?php
Yii::app()->clientScript->registerScript('problemconfig-js', '
    var fremovetc = function(){
        $(this).parent().parent().remove();
        if ($(".testcase").size() == 0)
        {
            $("tr#testcaseempty").show();
        }
        return false;
    };
    $(".removetestcase").click(fremovetc);

    $("#addtestcase").click(function(){

        var lasttestcaseid = $("input#lasttestcaseid").val();
        var input = $("#newtestcase_input").val();

        var output = $("#newtestcase_output").val();
        var a = $("tr#testcaseempty").after("<tr class=\"testcase\">\n"+
                            "<td><input type=\"text\" class=\"filename\" name=\"config[testcases]["+lasttestcaseid+"][input]\" readonly=\"readonly\" value=\""+input+"\"></td>\n"+
                            "<td><input type=\"text\" class=\"filename\" name=\"config[testcases]["+lasttestcaseid+"][output]\" readonly=\"readonly\" value=\""+output+"\"></td>\n"+
                            "<td><a href=\"#\" class=\"removetestcase\">Remove</a></td>\n\</tr>");


        if ($(".testcase").size() > 0)
        {
            $("tr#testcaseempty").hide();
        }
        lasttestcaseid++;
        $("input#lasttestcaseid").val(lasttestcaseid);
        $(".removetestcase").click(fremovetc);
        return false;
    });
');
?>
<?php echo CHtml::beginForm('?action=configuration');?>
<div id="configform">
    <div class="dtable">
        <div class="drow">
            <span class="shead">Execution Time Limit</span>
            <span>
                <input name="config[time_limit]" type="text" value="<?php echo $problem->getConfig('time_limit'); ?>"/> millisecond
            </span>
        </div>
        <div class="drow">
            <span class="shead">Execution Memory Limit</span>
            <span>
                <input name="config[memory_limit]" type="text" value="<?php echo $problem->getConfig('memory_limit'); ?>"/> bytes
            </span>
        </div>
        <div class="drow">
		<span class="shead">Testcases</span>
		<span>
			<table id="tabletestcases">
				<thead>
                    <tr>
                        <th>Input</th>
                        <th>Output</th>
                        <th></th>
                    </tr>
					<?php $ff = $problem->getFileList('evaluator/files', false);?>
					<?php $ff = array_keys($ff)?>
					<?php $filenames = array();?>
					<?php foreach($ff as $f) {$filenames[$f] = $f;}?>
						<tr id="createnewtestcase">
							<th>
								<select name="newtestcase_input" id ="newtestcase_input">
									<?php foreach($filenames as $key => $value):?>
									<option value="<?php echo $key;?>"><?php echo $value;?></option>
									<?php endforeach;?>
								</select>
							</th>
							<th>
								<select name="newtestcase_output" id ="newtestcase_output">
									<?php foreach($filenames as $key => $value):?>
									<option value="<?php echo $key;?>"><?php echo $value;?></option>
									<?php endforeach;?>
								</select>
							</th>
                            <th><a href="#" id="addtestcase">Add</a></th>
                        </tr>
				</thead>
				<tbody>
					<?php $testcases = $problem->getConfig('testcases')?>
                    <?php $i = 0;?>
					<input type="hidden" name="lasttestcaseid" id="lasttestcaseid" value="<?php echo count($testcases);?>"/>
					<?php if(count($testcases) > 0):?>
                        <?php foreach($testcases as $testcase):?>
						<tr class="testcase">
							<td>
								<input type="text" value="<?php echo $testcase['input'];?>" name="<?php echo "config[testcases][".$i."][input]";?>" readonly="readonly"/>
							</td>
							<td>
								<input type="text" value="<?php echo $testcase['output'];?>" name="<?php echo "config[testcases][".$i."][output]";?>" readonly="readonly"/>

							</td>
							<td><a href="#" class="removetestcase">Remove</a></td>
                        </tr>
						<?php $i++;?>
						<?php endforeach;?>
						<tr id="testcaseempty" style="display:none">
                            <td colspan="4">No testcases</td>
                        </tr>
					<?php else:?>
                        <tr id="testcaseempty">
                            <td colspan="4">No testcases</td>
                        </tr>
					<?php endif;?>
				</tbody>
			</table>
		</span>
	</div>
        <div class="drow">
            <span>
                <input type="submit" value="Simpan"/>
            </span>
        </div>
    </div>
</div>
<?php echo CHtml::endForm();?>
<hr/>
<div id="zipuploadform">
    <div class="dtable">
        <div class="drow">
            <span class="shead">Unggah berkas zip</span>
            <span>
                <?php echo CHtml::beginForm('?action=zipupload','post', array('enctype' => 'multipart/form-data'));?>
                <?php echo CHtml::fileField('file'); ?>
                <?php echo CHtml::submitButton('Unggah'); ?>
                <?php echo CHtml::endForm();?>
                <p>Unggah sebuah berkas *.zip berisi pasangan berkas *.in dan *out</p>
            </span>
        </div>
    </div>
</div>