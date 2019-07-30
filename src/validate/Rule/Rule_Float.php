<?php

namespace XWX\Common\validate\Rule;


use XWX\Common\XReturn;

class Rule_Float extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        $is_pass = filter_var($val, FILTER_VALIDATE_FLOAT) !== false;
        if (!$is_pass)
        {
            return $this->funcGetR(-1033, $this->getErrMsg());
        }

        return $this->funcGetR(0);
    }
}