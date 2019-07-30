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
            $msg = json_encode($msg, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        print $msg . PHP_EOL;
    }

    /**
     * @return H
     */
    function H()
    {
        return new H();
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