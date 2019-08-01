<?php

namespace XWX\Common\Validate\Rule;


use XWX\Common\XReturn;

class Rule_Regex extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        $is_pass = false;
        if (is_numeric($val) || is_string($val))
        {
            $reg = $this->getArgs(0);
            $is_pass = preg_match($reg, $val);
        }

        if (!$is_pass)
        {
            return $this->funcGetR(-1022, $this->getErrMsg());
        }


        return $this->funcGetR(0);
    }
}