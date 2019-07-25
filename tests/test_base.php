<?php

namespace Tests;


class test_base extends TestBase
{
    function test_trueOrFalse()
    {
        $this->funcLog('=======true or false======');
        $this->funcLog('空字符串：' . ('' ? 'true' : 'false'));
        $this->funcLog('空数组:' . ([] ? 'true' : 'false'));
        $this->funcLog('数字0的字符串:' . ('0' ? 'true' : 'false'));
        $this->funcLog('数字0:' . (0 ? 'true' : 'false'));

        $this->funcLog('=======null======');
        $this->funcLog('空字符串 == null：' . ('' == null ? 'true' : 'false'));
        $this->funcLog('空字符串 === null：' . ('' === null ? 'true' : 'false'));
        $this->funcLog('空数组 == null：' . ([] == null ? 'true' : 'false'));
        $this->funcLog('数字0的字符串 == null：' . ('0' == null ? 'true' : 'false'));
        $this->funcLog('数字0 == null：' . (0 == null ? 'true' : 'false'));

        $this->funcLog('======is_null=======');
        $this->funcLog('空字符串：' . (is_null('') ? 'true' : 'false'));
        $this->funcLog('空数组：' . (is_null([]) == null ? 'true' : 'false'));
        $this->funcLog('数字0的字符串：' . (is_null('0') == null ? 'true' : 'false'));
        $this->funcLog('数字0：' . (is_null(0) == null ? 'true' : 'false'));

        $this->assertTrue(true);
    }

    function test_isWin()
    {
        $this->assertTrue($this->H()->funcIsWin());
    }

}