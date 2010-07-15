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

    $(".batch").live("change" , function() {
        var no = $(this).attr("id");
        no = parseInt(no.substr(2 , no.length));
        var value = $(this).val();
        //alert(value);
        $(".select").each(function() {
            if ($(this).attr("checked") == true) {
                var no2 = $(this).attr("id");
                no2 = parseInt(no2.substr(2 , no2.length));
                $("#b_" + no2).val(value);
                $(this).attr("checked" , false);
            }
        });
    });

    $("#trigger").change(function() {
        var val = $(this).attr("checked") == true;
        $(".select").each(function() {
            $(this).attr("checked" , val);
        });
    });

    $("#spread").click(function() {
        $(".batch").each(function() {
            var no2 = $(this).attr("id");
            no2 = parseInt(no2.substr(2 , no2.length));
            $(this).val(no2 + 1);
        });
        return false;
    });

    $("#addtestcase").click(function(){

        var lasttestcaseid = $("input#lasttestcaseid").val();
        var input = $("#newtestcase_input").val();
        var output = $("#newtestcase_output").val();
        var batch = ($("#newbatch").val() == "") ? lasttestcaseid : $("#newbatch").val();
        var sample = $("input[name=\'newsample\']").attr("checked");
        
        if (sample) sample = "checked=\"yes\""; else sample="";

        var a = $("tr#testcaseempty").after("<tr class=\"testcase\">\n"+
                            "<td><input type=\"checkbox\" class=\"select\" id=\"c_"+lasttestcaseid+"\" name=\"config[testcases]["+lasttestcaseid+"][selected]\" /></td>\n"+
                            "<td><input type=\"text\" class=\"filename\" name=\"config[testcases]["+lasttestcaseid+"][input]\" readonly=\"readonly\" value=\""+input+"\"></td>\n"+
                            "<td><input type=\"text\" class=\"filename\" name=\"config[testcases]["+lasttestcaseid+"][output]\" readonly=\"readonly\" value=\""+output+"\"></td>\n"+
                            "<td><input type=\"checkbox\" class=\"filename\" name=\"config[testcases]["+lasttestcaseid+"][sample]\" readonly=\"readonly\" " + sample +" value=\"on\"></td>\n"+
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
            <span class="shead">Checker Command Line</span>
            <span>
                <input name="config[command_line]" type="text" value="<?php echo $problem->getConfig('command_line'); ?>"/>
                <br />
                <br />
                Kosongkan untuk menggunakan pemeriksaan standar <br />
                [PROBLEM_PATH] : lokasi berkas soal <br />
                [INPUT] : lokasi berkas input resmi <br />
                [OUTPUT] : lokasi berkas output peserta <br />
                [OUTPUT_KEY] : lokasi output resmi <br />
                <strong>Selalu awali dengan [PROBLEM_PATH]/grader</strong>
            </span>
        </div>
        <div class="drow">
            <span class="shead">Sample Grading Contest</span>
            <span>
                <input name="config[sample_contest]" type="text" value="<?php echo $problem->getConfig('sample_contest'); ?>"/>
            </span>
        </div>
        <div class="drow">
			<span class="shead">Testcases</span>
			<span>
						<a href="#" id="spread">Auto spread</a><br /><br /><br />
				<table id="tabletestcases">
					<thead>
						<tr>
							<th><input type="checkbox" id="trigger" name="trigger" /></th>
							<th>Input</th>
							<th>Output</th>
							<th>Sample</th>
							<th>Subtask</th>
							<th></th>
						</tr>
						<?php $ff = $problem->getFileList('evaluator/files', false);?>
						<?php $ff = array_keys($ff)?>
						<?php $filenames = array();?>
						<?php foreach($ff as $f) {$filenames[$f] = $f;}?>
							<tr id="createnewtestcase">
															<th></th>
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
									<input class="select" id="c_<?php echo $i;?>" type="checkbox" name="<?php echo "config[testcases][".$i."][selected]";?>" />
								</td>
								<td>
									<input type="text" value="<?php echo $testcase['input'];?>" name="<?php echo "config[testcases][".$i."][input]";?>" readonly="readonly"/>
								</td>
								<td>
									<input type="text" value="<?php echo $testcase['output'];?>" name="<?php echo "config[testcases][".$i."][output]";?>" readonly="readonly"/>
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
								<td colspan="5">No testcases</td>
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