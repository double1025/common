<?php

namespace Tests;


use PHPUnit\Framework\TestCase;
use XWX\Common\Helper;
use XWX\Common\XReturn;

class TestBase extends TestCase
{
    function funcLog($msg)
    {
        print $msg . PHP_EOL;
    }

    /**
     * @return Helper
     */
    function H()
    {
        return Helper::funcInsStatic();
    }


    /**
     *
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