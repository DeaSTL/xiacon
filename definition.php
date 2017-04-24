<?php
// include "header.php";
// $link = new mysqli("localhost","root","","entries");

// $link = new mysqli('localhost', 'root', '', 'entries');

// function escape($link, $string)
// {
//     return $link->real_escape_string($string);
// }

// function get_definition($word){
// 	global $link;
//     $word = escape($link, $word);
// 	$o = $link->query("SELECT `definition` FROM `entries` WHERE `word`='$word'");
// 	return $o->fetch_all();
// }

// if(isset($_GET['q'])){
// 	// foreach(get_definition($_GET['q']) as $def){
// 	// 	// print_r($_GET['q']);
// 	// 	// print_r(" - ");
// 	// 	// print_r($def[0]);
// 	// 	// print_r('<br>');
//  //        var_dump($def);
// 	// }
// }

require_once __DIR__.'/header.php';

$link = new mysqli('localhost', 'root', '', 'entries');

function escape($link, $string)
{
    return $link->real_escape_string($string);
}

$return = [
    'error' => [
        'result' => true,
        'message' => '',
    ],
    'result' => [],
];

if (isset($_GET['q'])) {
    $word = escape($link, $_GET['q']);
    // echo("SELECT `definition` FROM `entries` WHERE `word`='$word'");
    $q = $link->query("SELECT `definition` FROM `entries` WHERE `word`='$word'");
    $return['error']['result'] = false;
    $return['result'] = $q->fetch_all();
    // var_dump($q->fetch_all());
} else {
    $return['error']['message'] = 'Data is empty!';
}

// echo json_encode($return);

if (!$return['error']['result']) {
    foreach ($return['result'] as $def) {
        print_r($_GET['q'].' - '.$def[0].'<br>');
    }
}
