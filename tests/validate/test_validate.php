<?php

namespace Tests\validate;


use Tests\TestBase;
use XWX\Common\Validate\Validate;

class test_validate extends TestBase
{
    function test_1010()
    {
        $v = new Validate();
        $v->addColumn('aaa')
            ->max(3, '666');
        $v->addColumn('bbb')
            ->max(1, '大了');

        $r = $v->validate([
            'aaa' => 5,
            'bbb' => 3,
        ], false);

        $this->funcLog($v->getErrors());
        $this->assertFalse($r);
    }
}