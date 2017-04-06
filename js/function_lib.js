function get_page_json(filename){
	var xhttp = new XMLHttpRequest();
	var response = "";
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	       response = xhttp.responseText;
	    }
	};
	xhttp.open("GET", filename, true);
	xhttp.send();
	return response;

}