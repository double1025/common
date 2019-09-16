<?php
require_once '../vendor/autoload.php';

$string1 = 'JSESSIONID=374B8B31E829DFBB89744E7CD2A2A616; WJJ_YY_OAUTH2_OPENID=ocOeEjkWwlxEDSAds4hpIEhdx708; WJJ_YY_OAUTH2_TIMESTAMP=1568641028860; WJJ_YY_OAUTH2_TOKEN=075e4fad972950413d558b89049bbc6f; WJJ_YY_OAUTH2_OPENID_CUS_256764=ofDH-v9yaEU4Ay4JKaGZY9ovP0lg';
$arr = explode('; ', $string1);

$list = [];
$index = 1;
foreach ($arr as $item)
{
    $d = explode('=', $item);

    $data = [
        "domain" => "256764.m.chaoapp.cn",
        "name" => $d[0],
        "path" => "/",
        "value" => $d[1],
        "id" => $index++,
        "hostOnly" => false,
        "httpOnly" => false,
        "sameSite" => "unspecified",
        "secure" => false,
        "session" => true,
        "storeId" => "0",
    ];

    $list[] = $data;
}

echo json_encode($list);