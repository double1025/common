<?php
//require_once '../vendor/autoload.php';

//echo '123';

$url = 'https://www.baidu.com/';
$client = new \XWX\Common\WebClient\WebClientCo($url);

$client->get();