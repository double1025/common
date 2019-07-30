<?php

namespace XWX\Common\validate\Rule;


use XWX\Common\H;
use XWX\Common\XReturn;

class Rule_Between extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        if (!is_numeric($val) && !is_string($val))
        {
            return $this->funcGetR(-1015, $this->getErrMsg());
        }

        $min = $this->getArgs(0);
        $max = $this->getArgs(1);

        if ($val <= $max && $val >= $min)
        {
            //pass
        }
        else
        {
            return $this->funcGetR(-1027, $this->getErrMsg());
        }


        return $this->funcGetR(0);
    }
}