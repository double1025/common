<?php
require_once '../vendor/autoload.php';

$data = " 
<note> 
<to>Tove</to> 
<from>Jani</from> 
<heading>Reminder</heading> 
<body>Don't forget me this weekend!</body> 
</note>";

$xml = simplexml_load_string($data);
$xml->addChild('xx', '123');
$xml->body = '123';
//var_dump($xml->body);
//var_dump($xml->asXML());
header("Content-type: text/xml");
echo $xml->asXML();