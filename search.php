<?php 
	$link = new mysqli("localhost","root","","entries");

	function search($query){
		global $link;
		$o = $link->query("SELECT `word` FROM `entries` WHERE `word` LIKE '$query%' LIMIT 50");
		return $o->fetch_all(); 

	}
	if(isset($_GET['q'])){
		echo json_encode(search($_GET['q']));
	}
?>