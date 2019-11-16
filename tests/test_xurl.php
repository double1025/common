<?php

namespace Tests;


use XWX\Common\XUrl;

class test_xurl extends TestBase
{
    function test_1010()
    {
        $url = '_template/head/head.wx.jssdk.html?dev=true&a=1';
//        $url = 'https://www.baidu.com/s/index?wd=php&rsp=0&rsv_sug4=16794';
        $xurl = new XUrl($url);

        $this->funcLog($xurl);
        $this->funcLog($xurl->getQuery('a'));

        $this->assertEquals($xurl->page_name(), 'head.wx.jssdk.html');
        $this->assertEquals($xurl->http_root(), null);
        $this->assertEquals($xurl->getQuery('a'), '1');
    }
}