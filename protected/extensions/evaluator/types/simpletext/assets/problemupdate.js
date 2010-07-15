var nProblems = 5;

var saveanswer = function(){
    problems[problemidx - 1]['answer'] = $('#problemanswer').val();
	problems[problemidx - 1]['point'] = $('#point').val();
    problems[problemidx - 1]['question'] = CKEDITOR.instances.problemquestion.getData();
	problems[problemidx - 1]['alternatives'] = new Array();
	for (var i = 0 ; i < nProblems ; i++) {
		problems[problemidx - 1]['alternatives'][i] = new Array();
		problems[problemidx - 1]['alternatives'][i]['answer'] = $("#alternatives_" + i).val();
		problems[problemidx - 1]['alternatives'][i]['point'] = $("#alt_point_" + i).val();
	}
}

var savedata = function(){
    saveanswer();
    $('#problemcontainer').html('');
    var str = '';
    for(i = 0; i < problems.length; i++){
        str += ('<input type="hidden" name="config[problems]['+i+'][question]" value="'+escape(problems[i]['question'])+'"/>');
        str += ('<input type="hidden" name="config[problems]['+i+'][answer]" value="'+escape(problems[i]['answer'])+'"/>');
		str += ('<input type="hidden" name="config[problems]['+i+'][point]" value="'+problems[i]['point']+'"/>');

		for (var j = 0 ; j < nProblems ; j++) {
			//alert(problems[i]['alternatives'][j]['answer']);
			//alert('<input type="hidden" name="config[problems]['+i+'][alternatives]['+j+'][answer]" value="'+problems[i]['alternatives'][j]['answer']+'"/>');
			str += ('<input type="hidden" name="config[problems]['+i+'][alternatives]['+j+'][answer]" value="'+escape(problems[i]['alternatives'][j]['answer'])+'"/>');
			str += ('<input type="hidden" name="config[problems]['+i+'][alternatives]['+j+'][point]" value="'+problems[i]['alternatives'][j]['point']+'"/>');
		}
    }
    $('#problemcontainer').append(str);
}

var updatedetail = function(){
    CKEDITOR.instances.problemquestion.setData(problems[problemidx - 1]['question']);
    $('#problemanswer').val(problems[problemidx - 1]['answer']);
	$('#point').val(problems[problemidx - 1]['point']);
	for (var i = 0 ; i < nProblems ; i++) {
		$('#alternatives_' + i).val(problems[problemidx - 1]['alternatives'][i]['answer']);
		$('#alt_point_' + i).val(problems[problemidx - 1]['alternatives'][i]['point']);
	}
}

var updateproblem = function(){
    $('#problemcount').html(problems.length);
    $('#problemslider').slider({
            "max" : problems.length,
            "min" : 1,
            "value" : problemidx
        });
    $('#problemslider').slider("value", problemidx);
    $('#problemchooser').html('');
    for (i = 1; i <= problems.length; i++){
        $('#problemchooser').append('<option value="'+i+'" selected="selected">'+i+'</option>');
    }
    $('#problemchooser').val(problemidx);
}

var problemchooserslide = function(event, ui){
    saveanswer();
    $('#problemchooser').val(ui.value);
    problemidx = ui.value;
    updatedetail();
}

$('#problemchooser').change(function(){
    saveanswer();
    $('#problemslider').slider("value", $(this).val());
    problemidx = $(this).val();
    updatedetail();
})

$('.backslider').click(function(){
    saveanswer();
    if (problemidx > 1) {problemidx--;}
    $('#problemslider').slider("value", problemidx);
    $('#problemchooser').val(problemidx);
    updatedetail();
})

$('.nextslider').click(function(){
    saveanswer();
    if (problemidx < problems.length) {problemidx++;}
    $('#problemslider').slider("value", problemidx);
    $('#problemchooser').val(problemidx);
    updatedetail();
})

$('.deleteproblembutton').click(function(){
    if (confirm('Are you sure want to delete this problem?')){
        if (problems.length == 1){
            alert('Could not delete the only problem left');
        } else {
            //alert(problems.length);
            problems.splice(problemidx - 1, 1);
            if (problemidx > 1){
                problemidx--;
            }
            
            updateproblem();
            updatedetail();
        }
    }
});

$('#newproblembutton').click(function(){
    //alert(problemidx);
	saveanswer();
    problems.push({"question" : "Question", "answer" : "Answer", 'point' : 1 , 'alternatives' : []});
	for (var i = 0 ; i < nProblems ; i++) {
		problems[problemidx]['alternatives'][i] = {'answer' : 'Answer' , 'point' : 1};
	}

    problemidx = problems.length;
    updateproblem();
    updatedetail();
})

$('.submitproblems').click(function(){
    savedata();
    return true;
})