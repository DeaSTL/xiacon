<?php

require_once __DIR__.'/init.php';

$db = new Core\Database();

$return = [
    'error' => [
        'result'  => true,
        'message' => '',
    ],
    'result' => [],
];

if (isset($_GET['q'])) {
    $db->orderBy('word', 'ASC')
    ->setLimit(50)->select('entries', ['word', 'LIKE', $_GET['q'].'%']);

    if ($db->count()) {
        $return['error']['result'] = false;
        foreach ($db->all() as $item) {
            $return['result'][] = $item->word;
        }
    }
} else {
    $return['error']['message'] = 'Data is empty!';
}

echo json_encode($return);
