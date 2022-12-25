<?php
define("AppiEngine", true);

header('Powered: Alexander Pozharov');
header("Cache-control: public");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 60 * 60 * 24) . " GMT");
header('Content-Type: application/json');

spl_autoload_register(function($class) {
    include_once str_replace('\\', '/', $class) . '.php';
});

//ini_set('display_errors', '1');

//$redis = new \Redis();
//$redis->connect('localhost');

$lp = new \Server\Core\LongPoll();

if (!isset($_GET['token'])) {
    echo json_encode([
        'error' => 'Нет токена'
    ], JSON_UNESCAPED_UNICODE);
    die;
}

$friendsList = '';
$messageList = '';

while (true) {
    //$friendsList = $lp->checkAddFriend($_GET['token']);
    //$messageList = $lp->checkMessage($_GET['token']);

    //if ($friendsList || $messageList) {
    //    break;
    //}

    usleep(500000);
}

echo json_encode([
    'Friends' => $friendsList,
    'Message' => $messageList
], JSON_UNESCAPED_UNICODE);