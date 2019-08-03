<?php

namespace Tests\validate;


use Carbon\Carbon;
use function foo\func;
use Tests\TestBase;
use XWX\Common\Validate\Validate;

class test_validate extends TestBase
{
    function test_alpha()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->alpha();
        $v->addColumn('t2')
            ->alpha();
        $v->addColumn('t3')
            ->alpha();

        $r = $v->validate([
            't1' => "abc",
            't2' => "abc123",
            't3' => "!@#",
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t2', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
    }

    function test_alphaNumLine()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->alphaNumLine();
        $v->addColumn('t2')
            ->alphaNumLine();
        $v->addColumn('t3')
            ->alphaNumLine();
        $v->addColumn('t4')
            ->alphaNumLine();

        $r = $v->validate([
            't1' => "abc",
            't2' => "ab!c_#123",
            't3' => "abc_123",
            't4' => "a#b",
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t2', $v->getErrors());
        $this->assertArrayHasKey('t4', $v->getErrors());
    }

    function test_between()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->between(1, 5);
        $v->addColumn('t2')
            ->between(2, 10);
        $v->addColumn('t3')
            ->between(1, 5);
        $v->addColumn('t4')
            ->between(1, 5);

        $r = $v->validate([
            't1' => "abc",
            't2' => "0",
            't3' => 1,
            't4' => 6,
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t2', $v->getErrors());
        $this->assertArrayHasKey('t4', $v->getErrors());
    }

    function test_dateAfter()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->dateAfter(Carbon::parse('2019-08-01'));
        $v->addColumn('t2')
            ->dateAfter(Carbon::parse('2019-08-05 22:09:55'));
        $v->addColumn('t3')
            ->dateAfter(Carbon::parse('2019-08-02'));

        $r = $v->validate([
            't1' => '2019-08-01',
            't2' => "2019-08-05 22:09:56",
            't3' => "2019-08-01",
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
    }

    function test_dateBefore()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->dateBefore(Carbon::parse('2019-08-01'));
        $v->addColumn('t2')
            ->dateBefore(Carbon::parse('2019-08-05 22:09:55'));
        $v->addColumn('t3')
            ->dateBefore(Carbon::parse('2019-08-02'));

        $r = $v->validate([
            't1' => '2019-07-31',
            't2' => "2019-08-05 22:09:54",
            't3' => "2019-08-01",
        ], true);

        $this->assertEquals(true, $r);
        //不能 $key
//        $this->assertArrayHasKey('t1', $v->getErrors());
//        $this->assertArrayHasKey('t3', $v->getErrors());
    }

    function test_decimal()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->decimal();
        $v->addColumn('t2')
            ->decimal();
        $v->addColumn('t3')
            ->decimal();
        $v->addColumn('t4')
            ->decimal();
        $v->addColumn('t5')
            ->decimal();
        $v->addColumn('t6')
            ->decimal(2);
        $v->addColumn('t7')
            ->decimal(3);

        $r = $v->validate([
            't1' => "abc",
            't2' => "12.12",
            't3' => "00.12",
            't4' => 1,
            't5' => 1.123,
            't6' => 1.123,
            't7' => 1.123,
        ], true);

//        $this->funcLog($v->getErrors());
        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayNotHasKey('t3', $v->getErrors());
        $this->assertArrayHasKey('t6', $v->getErrors());
    }

    function test_equal()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->equal('123');
        $v->addColumn('t2')
            ->equal(333);
        $v->addColumn('t3')
            ->equal(125.21);

        $r = $v->validate([
            't1' => 123,
            't2' => "333",
            't3' => 125.22,
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t2', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
    }

    function test_func()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->func(function ($val)
            {
                return $val == '123';
            });
        $v->addColumn('t2')
            ->func(function ()
            {
                return false;
            });

        $r = $v->validate([
            't1' => "123",
            't2' => "abc123",
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
//        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t2', $v->getErrors());
    }

    function test_inteagr()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->integer();
        $v->addColumn('t2')
            ->integer();
        $v->addColumn('t3')
            ->integer();

        $r = $v->validate([
            't1' => "abc",
            't2' => "123",
            't3' => "12.123",
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
    }

    function test_isIp()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->isIp();
        $v->addColumn('t2')
            ->isIp();
        $v->addColumn('t3')
            ->isIp();

        $r = $v->validate([
            't1' => "abc",
            't2' => "192.168.0.88",
            't3' => "12.123",
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
    }

    function test_isJson()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->isJson();
        $v->addColumn('t2')
            ->isJson();
        $v->addColumn('t3')
            ->isJson();
        $v->addColumn('t4')
            ->isJson();
        $v->addColumn('t5')
            ->isJson();

        $r = $v->validate([
            't1' => "abc",
            't2' => "192.168.0.88",
            't3' => [1, 3, 2],
            't4' => json_encode([1, 3, 2]),
            't5' => '{"array":[1,2,3],"boolean":true,}',
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t2', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
        $this->assertArrayNotHasKey('t4', $v->getErrors());
        $this->assertArrayHasKey('t5', $v->getErrors());
    }

    function test_lenBetween()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->lenBetween(2, 3);
        $v->addColumn('t2')
            ->lenBetween(2, 3);
        $v->addColumn('t3')
            ->lenBetween(2, 3);

        $r = $v->validate([
            't1' => "abc",
            't2' => "a",
            't3' => "12345",
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t2', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
    }

    function test_lenMax()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->lenMax(2);
        $v->addColumn('t2')
            ->lenMax(2);
        $v->addColumn('t3')
            ->lenMax(2);

        $r = $v->validate([
            't1' => "abc",
            't2' => "a",
            't3' => "12345",
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayNotHasKey('t2', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
    }

    function test_lenMin()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->lenMin(2);
        $v->addColumn('t2')
            ->lenMin(2);
        $v->addColumn('t3')
            ->lenMin(2);

        $r = $v->validate([
            't1' => "abc",
            't2' => "a",
            't3' => "12345",
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayNotHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t2', $v->getErrors());
        $this->assertArrayNotHasKey('t3', $v->getErrors());
    }

    function test_max()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->max(2);
        $v->addColumn('t2')
            ->max(2);
        $v->addColumn('t3')
            ->max(2);

        $r = $v->validate([
            't1' => 1,
            't2' => 2,
            't3' => 3,
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayNotHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t2', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
    }

    function test_min()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->min(2);
        $v->addColumn('t2')
            ->min(2);
        $v->addColumn('t3')
            ->min(2);

        $r = $v->validate([
            't1' => 1,
            't2' => 2,
            't3' => 3,
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t2', $v->getErrors());
        $this->assertArrayNotHasKey('t3', $v->getErrors());
    }

    function test_regex()
    {
//        $v = new Validate();
//        $v->addColumn('t1')
//            ->regex("^(http://)?([^/]+)/i");
//        $v->addColumn('t2')
//            ->regex("^(http://)?([^/]+)/i");
//
//        $r = $v->validate([
//            't1' => 'http://baidu.com',
//            't2' => '123123',
//        ], true);
//
//        $this->assertEquals(false, $r);
//        //不能 $key
//        $this->assertArrayNotHasKey('t1', $v->getErrors());
//        $this->assertArrayHasKey('t2', $v->getErrors());
    }

    function test_required()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->required();
        $v->addColumn('t2')
            ->required();
        $v->addColumn('t3')
            ->required();
        $v->addColumn('t4')
            ->required();

        $r = $v->validate([
            't1' => 1,
            't2' => '',
            't3' => null,
            't4' => 'null',
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayNotHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t2', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
        $this->assertArrayNotHasKey('t4', $v->getErrors());
    }

    function test_url()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->url();
        $v->addColumn('t2')
            ->url();
        $v->addColumn('t3')
            ->url();

        $r = $v->validate([
            't1' => '123',
            't2' => 'http://baidu.com',
            't3' => 'http:',
        ], true);

        $this->assertEquals(false, $r);
        //不能 $key
        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayNotHasKey('t2', $v->getErrors());
        $this->assertArrayHasKey('t3', $v->getErrors());
    }


    function test_validate_1010()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->required()
            ->lenBetween(0, 10)
            ->url();
        $v->addColumn('t2')
            ->required()
            ->lenBetween(0, 10)
            ->url();

        $r = $v->validate([
            't1' => '',
            't2' => 'http://baidu.com',
        ]);

        $this->assertEquals(false, $r);

        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayNotHasKey('t2', $v->getErrors());
    }

    function test_validate_1020()
    {
        $v = new Validate();
        $v->addColumn('t1')
            ->required()
            ->lenBetween(0, 10)
            ->url();
        $v->addColumn('t2')
            ->required()
            ->lenBetween(0, 10)
            ->url();

        $r = $v->validate([
            't1' => '',
            't2' => 'http://baidu.com',
        ], true);

        $this->assertEquals(false, $r);

        $this->assertArrayHasKey('t1', $v->getErrors());
        $this->assertArrayHasKey('t2', $v->getErrors());
    }
}