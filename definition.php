
<?php
include "header.php";
$link = new mysqli("localhost","root","","entries");

function get_definition($word){
	global $link;
	$o = $link->query("SELECT `definition` FROM `entries` WHERE `word`='$word'");
	return $o->fetch_all();
}

if(isset($_GET['q'])){
	foreach(get_definition() as $def){
		print_r($def);
	}
}

