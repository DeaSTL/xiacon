<?php

include "function_lib.php";


$return = [
    'error' => [
        'result' => true,
        'message' => '',
    ],
    'result' => [],
];

if (isset($_GET['q'])) {
    $query = escape($link, $_GET['q']);
    $q = $link->query("SELECT `word` FROM `entries` WHERE `word` LIKE '$query%' LIMIT 50");
    $return['error']['result'] = false;
    $return['result'] = $q->fetch_all();
} else {
    $return['error']['message'] = 'Data is empty!';
}

echo json_encode($return);
