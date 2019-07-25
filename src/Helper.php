<?php

namespace XWX\Common;


use XWX\Common\Traits\Helpers\TraitHelper;
use XWX\Common\Traits\Helpers\TraitHelperArray;
use XWX\Common\Traits\Helpers\TraitHelperStr;
use XWX\Common\Traits\TraitIns;

class Helper
{
    use TraitIns, TraitHelper, TraitHelperStr, TraitHelperArray;


    function funcIsWin()
    {
        $w = strtoupper(substr(PHP_OS, 0, 3));

        return $w === 'WIN';
    }
}