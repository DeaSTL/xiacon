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
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.log("Status: " + status + " // Error: " + error);
        }
    });
}