<?php

namespace XWX\Common\validate\Rule;


use XWX\Common\H;
use XWX\Common\XReturn;

class Rule_Func extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        $is_pass = call_user_func($this->getArgs(0), $val);
        if (!$is_pass)
        {
            return $this->funcGetR(-1016, $this->getErrMsg());
        }

        return $this->funcGetR(0);
    }
}