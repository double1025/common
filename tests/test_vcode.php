<?php

namespace Tests;

use XWX\Common\VCode\VerifyCode;

class test_vcode extends TestBase
{
    function test_img()
    {
        $v = new VerifyCode();
        $v->DrawCode();
    }
}