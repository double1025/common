<?php

namespace XWX\Common\Validate\Rule;


use XWX\Common\XReturn;

class Rule_Bool extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        if ($val === 1 || $val === true || $val === 0 || $val === false)
        {
            //pass
        }
        else
        {
            return $this->funcGetR(-1017, $this->getErrMsg());
        }


        return $this->funcGetR(0);
    }
}