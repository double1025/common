<?php

namespace Tests;


use XWX\Common\XEntity;

class test_xentity extends TestBase
{
    function test_101()
    {
        $data = [
            'aaa' => 123,
            'zzz' => 'abc'
        ];

        $app = new testEntity();
        $this->assertTrue($app->keyExists('xxx'));
        $this->assertTrue($app->keyExists('zzz'));

        $app->fill($data);
        $this->assertEquals($app->getVal('zzz'), 'abc');
        //
        $app->setVal('xxx', '123');
        $this->assertEquals($app->getVal('xxx'), '123');

        $this->funcLog($app->toArray());

    }
}

class testEntity extends XEntity
{
    protected $xxx;
    protected $zzz;
}