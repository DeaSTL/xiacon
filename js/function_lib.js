function get_page_json(filename){
	xm = new XMLHttpRequest();
	xm.open("GET",filename,true);
	xm.send(null);
	return xm.responseText;
}

// function search_database(query){
//     $.ajax({
//         url: 'search.php',
//         type: 'get',
//         dataType: 'json',
//         data: { q: query },
//         success: function(data, status, xhr) {
          
//             if(data.length == 0){
//                 document.getElementById("search_output").innerHTML = "";
//             }else{
//                 for(var i = 0;i<data.length;i++){
//                 document.getElementById("search_output").innerHTML += '<a href=definition.php?q=' + data[i] + '>'+ data[i] +'</a>' + "</br>";
//             }    
//             }
            
//         },
//         error: function(xhr, status, error) {
//             console.log("Status: " + status + " // Error: " + error);
//         }
//     });
// }

function search_database(query) {
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
                    // $("#search_output").html(tmp + data.result[i] + "<br>");
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
