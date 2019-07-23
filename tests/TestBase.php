<?php

namespace Tests;


use PHPUnit\Framework\TestCase;
use XWX\Common\Helper;

class TestBase extends TestCase
{
    /**
     * @return Helper
     */
    function H()
    {
        return Helper::funcIns();
    }
}