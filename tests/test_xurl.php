<?php

namespace Tests;


use XWX\Common\XUrl;

class test_xurl extends TestBase
{
    function test_1010()
    {
        $a = [1 => '123', 2 => '222', 3 => '334', 4 => '888'];
        $c = [];
        $b = $a + $c;
        var_dump($b);


        $url = '_template/head/head.wx.jssdk.html?dev=true&a=1';
        $url = 'https://www.baidu.com/s/index?wd=php&rsp=0&rsv_sug4=16794';
//        $url = "https://www.baidu.com?aa=123&bbb=123";
        $xurl = new XUrl($url);

        $this->funcLog($xurl);
        $this->funcLog($xurl->getQuery('a'));

        $this->assertEquals($xurl->page_name(), 'head.wx.jssdk.html');
        $this->assertEquals($xurl->root(), null);
        $this->assertEquals($xurl->getQuery('a'), '1');
    }
}