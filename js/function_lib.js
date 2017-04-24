function get_page_json(filename){
	xm = new XMLHttpRequest();
	xm.open("GET",filename,true);
	xm.send(null);
	return xm.responseText;
}
function search_database(query){
	$.ajax({
        url: 'search.php',
        type: 'get',
        dataType: 'json',
        data: { q: query },
        success: function(data, status, xhr) {
          
            if(data.length == 0){
                document.getElementById("search_output").innerHTML = "";
            }else{
                for(var i = 0;i<data.length;i++){
                document.getElementById("search_output").innerHTML += data[i] + "</br>";
            }    
            }
            
        },
        error: function(xhr, status, error) {
            console.log("Status: " + status + " // Error: " + error);
        }
    });
}