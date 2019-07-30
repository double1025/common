<?php

namespace XWX\Common\validate\Rule;


use XWX\Common\XReturn;

class Rule_AlphaNumLine extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        if (!is_string($val))
        {
            return $this->funcGetR(-1015, $this->getErrMsg());
        }

        $is_pass = preg_match('/^[a-zA-Z0-9\_]+$/', $val);
        if (!$is_pass)
        {
            return $this->funcGetR(-1022, $this->getErrMsg());
        }

        return $this->funcGetR(0);
    }
}