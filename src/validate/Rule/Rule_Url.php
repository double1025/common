<?php

namespace XWX\Common\Validate\Rule;


use XWX\Common\XReturn;

class Rule_Url extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        $is_pass = filter_var($val, FILTER_VALIDATE_URL) !== false;
        if (!$is_pass)
        {
            return $this->funcGetR(-1015, $this->getErrMsg());
        }


        return $this->funcGetR(0);
    }
}