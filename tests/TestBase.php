<?php

namespace Tests;


use PHPUnit\Framework\TestCase;
use XWX\Common\H;
use XWX\Common\XReturn;

class TestBase extends TestCase
{
    function funcLog($msg)
    {
        if (!is_string($msg))
        {
            $msg = H::funcArrayToStr($msg);
        }

        print $msg . PHP_EOL;
    }


    /**
     * 事务通用方法
     *
     * @param callable $test_mid
     * @return XReturn
     * @throws \Throwable
     */
    function funcTestTransaction(callable $func)
    {
        $r = \DB::transaction(function () use ($func)
        {
            $s = $func();

            \DB::rollBack();

            return $s;
        });

        return $r;
    }
}