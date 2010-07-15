var saveanswer = function(){
    answers[problemidx - 1] = $('#problemanswer').val();
}

var savedata = function(){
    saveanswer();
    $('#datawrapper').html('');
    var str = '';
    for(i = 0; i < questions.length; i++){
        str += ('<input type="hidden" name="Submission[answer]['+i+']" value="'+escape(answers[i])+'"/>');
    }
    $('#datawrapper').append(str);
}

var updatedetail = function(){
    $('#problem-question-wrapper').html(questions[problemidx - 1]);
    $('#problemanswer').val(answers[problemidx - 1]);
}

var problemchooserslide = function(event, ui){
    $('#problemchooser').val(ui.value);
    saveanswer();
    problemidx = ui.value;
    updatedetail();
}

$('#problemchooser').change(function(){
    $('#problemslider').slider("value", $(this).val());
    saveanswer();
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
    if (problemidx < questions.length) {problemidx++;}
    $('#problemslider').slider("value", problemidx);
    $('#problemchooser').val(problemidx);
    updatedetail();
})

$('.savebutton').click(function(){
    savedata();
    return true;
})

$('#finishbutton').click(function(){
    savedata();
    return true;
})