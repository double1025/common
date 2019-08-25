<?php

namespace Tests;


class test_common extends TestBase
{
    function test_1010()
    {
        $x = '123';

        print $x[5];
//        print __DIR__;

        $this->assertTrue(true);
    }
}