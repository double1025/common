<?php

namespace Tests;


use XWX\Common\H;
use XWX\Common\WebClient\WebClient;
use XWX\Common\XArray\XArray;
use XWX\Common\XReturn;

class test_webclient extends TestBase
{
    function test_1010()
    {
        $url = 'http://192.168.2.88/';
        $url = 'http://192.168.0.88/';
        $client = new WebClient($url);
        $client->setConnectTimeout(1);
        $res = $client->get();

//        $this->funcLog($res->err());
//        $this->funcLog($res->errcode);
//        $this->funcLog($res->errmsg);
        $this->funcLog($res->getBody());
//        $this->funcLog($res->getCurlInfo());
//        $this->funcLog($res->getHeaderLine());

        $this->assertTrue(true);
    }
}