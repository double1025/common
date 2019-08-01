<?php

namespace XWX\Common\Validate\Rule;


use XWX\Common\H;
use XWX\Common\XReturn;

class Rule_Required extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        if (H::funcStrIsNullOrEmpty($val))
        {
            return $this->funcGetR(-1015, $this->getErrMsg());
        }


        return $this->funcGetR(0);
    }
}