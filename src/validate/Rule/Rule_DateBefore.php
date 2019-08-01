<?php

namespace XWX\Common\Validate\Rule;


use Carbon\Carbon;
use XWX\Common\H;
use XWX\Common\XReturn;

class Rule_DateBefore extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        if (H::funcStrIsNullOrEmpty($val))
        {
            return $this->funcGetR(-1015, $this->getErrMsg());
        }

        if (is_string($val))
        {
            $val = Carbon::parse($val);
        }

        $arg_before_date = $this->getArgs(0);
        if ($val < $arg_before_date)
        {
            //pass
        }
        else
        {
            return $this->funcGetR(-1031, $this->getErrMsg());
        }


        return $this->funcGetR(0);
    }
}