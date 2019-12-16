<?php

namespace Tests;


use XWX\Common\H;
use XWX\Common\XArray\XArray;
use XWX\Common\XReturn;

class test_str extends TestBase
{
    function test_1010()
    {
        $str = 'app_admin_xx';

        $str1 = H::funcStrToCamelize($str);
        $str2 = H::funcStrToUnCamelize($str1);

        $this->funcLog($str);
        $this->funcLog($str1);
        $this->funcLog($str2);
    }
}