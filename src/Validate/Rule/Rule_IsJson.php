<?php

namespace XWX\Common\Validate\Rule;


use XWX\Common\XReturn;

class Rule_IsJson extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        if (!is_string($val))
        {
            return $this->funcGetR(-1013, $this->getErrMsg());
        }

        $is_pass = json_decode($val) != null;
        if (!$is_pass)
        {
            return $this->funcGetR(-1020, $this->getErrMsg());
        }

        return $this->funcGetR(0);
    }
}