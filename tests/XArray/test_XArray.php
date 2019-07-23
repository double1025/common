<?php

namespace Tests\XArray;

use Tests\TestBase;
use XWX\Common\Helper;
use XWX\Common\XArray\XArrBase;

class test_XArray extends TestBase
{
    function funcGetArr()
    {
        $arr = [
            'abc_id' => '1',
            'abc_site_id' => '1',
            'abc_table' => 'app',
            'abc_pid' => '1',
            'abc_order' => 1,
        ];

        $arr1 = [
            'abc_id' => '2',
            'abc_site_id' => '2',
            'abc_table' => '123123',
            'abc_pid' => '2',
            'abc_order' => 2,
        ];

        $arr2 = [
            'abc_id' => '3',
            'abc_site_id' => '3',
            'abc_table' => '333333',
            'abc_pid' => '3',
            'abc_order' => 3,
        ];

        $list = [$arr, $arr1, $arr2];


        $arr = XArrBase::funcIns($list);


        return $arr;
    }


    function test_Where()
    {
        $arr = $this->funcGetArr();

        $x = $arr->where('abc_id', '5')->first();
        $this->assertEmpty($x, '检查where方法[=]');

        $x1 = $arr->where('abc_order', 2, '<')->get();
        $this->assertTrue(count($x1) === 1, '检查where[<]');

        $x2 = $arr->where('abc_order', 2, '<=')->get();
        $this->assertTrue(count($x2) === 2, '检查where[<=]');

        $x3 = $arr->where('abc_table', 'pp', function ($a, $b)
        {
            return $this->H()->funcStrEndsWith($a, $b);
        })->first();
        $this->assertTrue($x3['abc_table'] === 'app', '检查where[匿名函数]');
    }

    function test_Select()
    {
        $arr = $this->funcGetArr();

        $x = $arr->select('abc_id,abc_table,abc_site_id')->get();
        $this->assertCount(3, $x, 'select检查数量');
        $this->assertTrue($this->H()::funcArrayGet($x[0], 'abc_order') == null, '检查select不存在的字段');
        $this->assertTrue($this->H()::funcArrayGet($x[0], 'abc_site_id') != null, '检查select存在的字段');

        $x1 = $arr->select('abc_id', true)->get();
        $this->assertEquals([['1'], ['2'], ['3']], $x1, '检查select只显示值');

        $x2 = $arr->select('abc_id,abc_order', true)->toArr1()->get();
        $this->assertEquals(['1', 1, '2', 2, '3', 3], $x2, '检查select只显示值，变1维数组');
    }
    
    function test_Order()
    {
        $arr = $this->funcGetArr();

        $x = $arr->order('abc_id', SORT_DESC)->get();
        $this->assertCount(3, $x, 'order检查数量');
        $this->assertTrue($x[0]['abc_id'] == '3', '检查排序，abc_id倒序');

        $x1 = $arr->order('abc_order', SORT_DESC)
            ->order('abc_table')
            ->get();
//        var_dump($x1);
        $this->assertTrue($x1[0]['abc_id'] != '3', '检查排序，组合使用');
    }
}