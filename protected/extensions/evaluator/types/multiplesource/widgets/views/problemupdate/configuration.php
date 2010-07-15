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
		var batch = ($("#newbatch").val() == "") ? lasttestcaseid : $("#newbatch").val();
        var sample = $("input[name=\'newsample\']").attr("checked");

        if (sample) sample = "checked=\"yes\""; else sample="";

        var a = $("tr#testcaseempty").after("<tr class=\"testcase\">\n"+
                            "<td><input type=\"text\" class=\"filename\" name=\"config[testcases]["+lasttestcaseid+"][input]\" readonly=\"readonly\" value=\""+input+"\"></td>\n"+
                            "<td><input type=\"checkbox\" class=\"filename\" name=\"config[testcases]["+lasttestcaseid+"][sample]\" readonly=\"readonly\" " + sample +" value=\"on\"></td>"+
							"<td><input style=\"width: 40px;\" type=\"text\" class=\"batch\" id=\"b_"+lasttestcaseid+"\" name=\"config[testcases]["+lasttestcaseid+"][batch]\" value=\""+batch+"\"></td>\n"+
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
            <span class="shead">Checker Source</span>
            <span>
                <input name="config[checker_source]" type="text" value="<?php echo $problem->getConfig('checker_source'); ?>"/>
            </span>
        </div>
        <div class="drow">
            <span class="shead">Grader Command Line</span>
            <span>
                <input name="config[command_line]" type="text" value="<?php echo $problem->getConfig('command_line'); ?>"/>
                <br />
                <br />
                [PROBLEM_PATH] : lokasi berkas soal <br />
                [SOLUTION_PATH] : lokasi ekstraksi berkas peserta <br />
            </span>
        </div>
        <?php /*
        <div class="drow">
			<span class="shead">Testcases</span>
			<span>
				<table id="tabletestcases">
					<thead>
						<tr>
							<th>Input</th>
							<th>Sample</th>
							<th>Subtask</th>
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
									<input name="newsample" type="checkbox" />
								</th>
								<th>
									<input style="width: 40px;" id="newbatch" name="newbatch" type="text" />
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
																<input type="checkbox" <?php if($testcase['sample']) echo "checked=\"yes\"";?>" value="on" name="<?php echo "config[testcases][".$i."][sample]";?>" readonly="readonly" />
															</td>
															<td>
																<input id="b_<?php echo $i?>" class="batch" type="text" style="width: 40px;" value="<?php echo $testcase['batch'];?>" name="<?php echo "config[testcases][".$i."][batch]";?>" />
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
			<span class="shead">Subtask</span>
			<span>
				<table>
					<thead>
						<tr>
							<th>Subtask</th>
							<th>Poin</th>
						</tr>
					</thead>
					<tbody>
						<?php $batchPoints = $problem->getConfig('batchpoints');?>
						<?php for ($i = 1 ; $i <= 25 ; $i++) : ?>
						<tr>
							<td><?php echo $i;?></td>
							<td>
								<input type="text" name="<?php echo 'config[batchpoints]['.$i.']'?>" value="<?php echo $batchPoints[$i];?>" />
							</td>
						</tr>
						<?php endfor;?>
					</tbody>
				</table>
			</span>
		</div>
         *
         */?>
        <div class="drow">
            <span>
                <input type="submit" value="Simpan"/>
            </span>
        </div>
    </div>
</div>
<?php echo CHtml::endForm();?>
<hr/>
<?php /*
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
 * */?>