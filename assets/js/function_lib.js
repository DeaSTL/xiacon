// Initialize jQuery
$(function ()
{
    // Use jQuery to do event listeners
    $("#search_bar").keyup(function (e) {
        $("#search_output").empty();
        if ($(this).val() !== '') {
            search_database($(this).val());
        }

    });
});

function search_database (query) {
    $.ajax({
        url: 'search.php',
        type: 'get',
        dataType: 'json',
        data: { q: query },
        success: function(data, status, xhr) {
            if (data.error.result === true) {
                console.log(data.error.message);
                $("#search_output").html(data.error.message);
            } else {

                for (var i = 0; i < data.result.length; i++) {
                    var tmp = $("#search_output").html();
                    $("#search_output").html(tmp 
                        + '<div class="panel panel-default" >'
                        +'<div class="panel-body">'
                        +'<a href="definition.php?q='
                        + data.result[i]
                        + '">'
                        + data.result[i]
                        + '</a></div></div><br>');
                }
            }
        },
        error: function(xhr, status, error) {
            console.log("Status: " + status + " // Error: " + error);
        }
    });
}
