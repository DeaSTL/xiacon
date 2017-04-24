
<?php
include "header.php";
$link = new mysqli("localhost","root","","entries");

function get_definition($word){
	global $link;
	$o = $link->query("SELECT `definition` FROM `entries` WHERE `word`='$word'");
	return $o->fetch_all();
}

if(isset($_GET['q'])){
	foreach(get_definition($_GET['q']) as $def){
		print_r($_GET['q']);
		print_r(" - ");
		print_r($def[0]);
		print_r('<br>');
	}
}

