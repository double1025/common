<?php

namespace Tests\xarray;

use Tests\TestBase;
use XWX\Common\XArray\XArray;

class test_memory extends TestBase
{
    public $pub_step_menory = [];

    function funcCollect($msg = null)
    {
        $m = memory_get_usage();

        $this->pub_step_menory[] = [
            'm' => $m,
            'msg' => $msg,
        ];
    }

    function funcShow()
    {
        $pre_m = 0;
        foreach ($this->pub_step_menory as $k => $v)
        {
            $m = $v['m'];
            $msg = $v['msg'];

            $r = ($m - $pre_m) / 1024;
            $r = (int)$r;

            if ($msg)
            {
                $this->funcLog($msg);
            }

            $this->funcLog("{$k}:{$m}");
            if ($pre_m != 0)
            {
                $this->funcLog("{$k}:与上次相差{$r}K");
            }

            //记录上一次
            $pre_m = $m;
        }
    }

    function funcGetArr()
    {
        $arr = [];
        $this->funcCollect();
        for ($i = 0; $i < 100000; $i++)
        {
            $arr[] = [
                'a' => 1.1,
                'b' => 1.2,
                'c' => 1.3,
                'd' => 1.5,
            ];
        }
        $this->funcCollect();

        return $arr;
    }


    function test_1010()
    {
        $arr = $this->funcGetArr();

        $xarr = XArray::funcIns($arr);
        $this->funcCollect();

        $query = $xarr->where('a', 1, '>');
        $this->funcCollect();
        $query->where('b', 1.1, '>');
        $this->funcCollect();
        $query->where('c', 1.1, '>');
        $this->funcCollect();
        $query->order('b', SORT_DESC);
        $this->funcCollect();
        $query->where('c', 1.1, '>');
        $this->funcCollect();
        $query->select(['a', 'd']);
        $this->funcCollect();
        $r = $query->get();
        $this->funcLog(count($r));

        $this->funcShow();
        $this->assertTrue(true);
    }
}