<?php

namespace XWX\Common;


use XWX\Common\Traits\Helpers\TraitHelper;
use XWX\Common\Traits\Helpers\TraitHelperArray;
use XWX\Common\Traits\Helpers\TraitHelperStr;

class Helper
{
    use TraitHelper, TraitHelperStr, TraitHelperArray;


    function test()
    {
        return 'test';
    }
}