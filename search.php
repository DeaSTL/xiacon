<?php 
	// $link = new mysqli("localhost","root","","entries");

	// function search($query){
	// 	global $link;
	// 	$o = $link->query("SELECT `word` FROM `entries` WHERE `word` LIKE '$query%' LIMIT 50");
	// 	return $o->fetch_all(); 

	// }
	// if(isset($_GET['q'])){
	// 	echo json_encode(search($_GET['q']));
	// }
include "function_lib.php";


$return = [
    'error' => [
        'result' => true,
        'message' => '',
    ],
    'result' => [],
];

if (isset($_GET['q'])) {
    $query = dictionary::escape($link, $_GET['q']);
    $q = $dictionary_link->query("SELECT `word` FROM `entries` WHERE `word` LIKE '$query%' LIMIT 50");
    $return['error']['result'] = false;
    $return['result'] = $q->fetch_all();
} else {
    $return['error']['message'] = 'Data is empty!';
}

echo json_encode($return);
