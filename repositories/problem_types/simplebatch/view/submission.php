<div class="dtable">
	<div class="drow">
		<span class="name">Bahasa Pemrograman</span>
		<span><?php echo $submission->getSubmitContent('source_lang');?></span>
	</div>
	<div class="drow">
		<span class="name">Nama Berkas</span>
		<span><?php echo $submission->getSubmitContent('original_name');?></span>
	</div>
	<div class="drow">
		<span class="name">Hasil</span>
		<span><?php echo $submission->getGradeContent('verdict');?></span>
	</div>
	<div class="drow">
		<span class="name">Keluaran Evaluator</span>
		<span><?php echo $submission->getGradeContent('output');?></span>
	</div>
</div>
<div><pre class="brush: text"></pre></div>	
<div class="dtable">	
	<div class="drow">
		<span class="name">Isi Berkas</span>
		<span>
			
		</span>
	</div>
</div>
<div>
	<pre class="brush: <?php echo $submission->getSubmitContent('source_lang');?>"><?php echo CHtml::encode($submission->getSubmitContent('source_content'));?></pre>
</div>
