<?php

namespace Tests;


use XWX\Common\XArray\XArray;
use XWX\Common\XReturn;

class test_common extends TestBase
{
    function test_1010()
    {
        $x = '123';

        print $x[5];
//        print __DIR__;

        $this->assertTrue(true);
    }

    function test_instanceof()
    {
        $r = new XReturn();
        $this->assertTrue($r instanceof XReturn);
        $this->funcLog($r);

        $r = new XArray();
        $this->assertFalse($r instanceof XReturn);
    }
}