<?php

namespace XWX\Common;


use XWX\Common\Traits\Helpers\TraitHelper;
use XWX\Common\Traits\Helpers\TraitHelperArray;
use XWX\Common\Traits\Helpers\TraitHelperStr;
use XWX\Common\Traits\TraitIns;

class Helper
{
    use TraitIns, TraitHelper, TraitHelperStr, TraitHelperArray;


    function test()
    {
        return 'test';
    }
}