<?php

namespace XWX\Common\Validate\Rule;


use XWX\Common\H;
use XWX\Common\XReturn;

class Rule_Equal extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        $arg = $this->getArgs(0);
        if ($val !== $arg)
        {
            return $this->funcGetR(-1016, $this->getErrMsg());
        }


        return $this->funcGetR(0);
    }
}