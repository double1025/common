<?php

namespace XWX\Common\Validate\Rule;


use XWX\Common\XReturn;

class Rule_LenMin extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        $is_pass = false;
        $min = $this->getArgs(0);

        if (is_string($val))
        {
            if (strlen($val) > $min)
            {
                $is_pass = true;
            }
        }
        else if (!is_array($val))
        {
            if (count($val) > $min)
            {
                $is_pass = true;
            }
        }

        if (!$is_pass)
        {
            return $this->funcGetR(-1033, $this->getErrMsg());
        }


        return $this->funcGetR(0);
    }
}