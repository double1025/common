<?php

namespace Tests;


use XWX\Common\H;
use XWX\Common\XArray\XArray;
use XWX\Common\XReturn;

class test_common extends TestBase
{
    function test_1010()
    {
        $x = '123';

//        print $x[5];
//        print __DIR__;

        $data = [
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => 5,
        ];

        $x = H::funcStrQueryFromArray($data, ['a', 'c', 1]);
        $this->funcLog($x);


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