<?php

namespace XWX\Common\validate\Rule;


use XWX\Common\H;
use XWX\Common\XReturn;

class Rule_Max extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        if (!is_numeric($val))
        {
            return $this->funcGetR(-1015, $this->getErrMsg());
        }

        $val = H::funcStrToInt($val);
        if ($val > $this->getArgs(0))
        {
            return $this->funcGetR(-1022, $this->getErrMsg());
        }


        return $this->funcGetR(0);
    }
}