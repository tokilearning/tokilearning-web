$(document).ready(function() {
    $("input[name=delete]").click(function(){
        return confirm('Do you really want to delete the selected users?');
    });

    $("input[name=password]").click(function(){
        return confirm('Do you really want to change passwords for the selected users?');
    });
    
});