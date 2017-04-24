<?php

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
    $q = $link->query("SELECT `definition` FROM `entries` WHERE `word`='$word'");
    $return['error']['result'] = false;
    $return['result'] = $q->fetch_all();
} else {
    $return['error']['message'] = 'Data is empty!';
}

if (!$return['error']['result']) {
    foreach ($return['result'] as $def) {
    	print_r('<div class="panel panel-primary"><div class="panel-heading">');
        print_r($_GET['q'].'<br></div>');
        print_r('<div class="panel-body">'.$def[0]);
        print_r("</div></div>");
    }
}
