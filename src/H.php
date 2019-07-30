<?php

namespace XWX\Common;


use XWX\Common\Traits\Helpers\TraitHelper;
use XWX\Common\Traits\Helpers\TraitHelperArray;
use XWX\Common\Traits\Helpers\TraitHelperStr;

class H
{
    use TraitHelper, TraitHelperStr, TraitHelperArray;


    static function funcIsWin()
    {
        $w = strtoupper(substr(PHP_OS, 0, 3));

        return $w === 'WIN';
    }
}