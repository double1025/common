<?php

namespace Tests\validate;


use XWX\Common\Validate\Validate;

class test_validate
{
    function test_1010()
    {
        $v = new Validate();
        $v->addColumn('xx')
            ->max(10, '')
            ->max(20, '');
    }
}