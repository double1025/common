<?php

namespace XWX\Common;


use App\Traits\Helpers\TraitHelperWeb;
use XWX\Common\Traits\Helpers\TraitHelper;
use XWX\Common\Traits\Helpers\TraitHelperArray;
use XWX\Common\Traits\Helpers\TraitHelperStr;

class Helper
{
    use TraitHelper, TraitHelperStr, TraitHelperArray, TraitHelperWeb;
}