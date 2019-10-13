<?php
require_once '../vendor/autoload.php';

//$v = new \XWX\Common\VCode\VerifyCode();
//$v->DrawCode('123');

$v = new \XWX\Common\XImage\VCode();
//$v->funcCodeSave(rand(1000, 9999), 'D:/1.jpg');
$v->funcCodeToPng(123);
//header("content-type:image/png");
//echo $v->funcCodeToBytes(rand(1000, 9999));