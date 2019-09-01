<?php

namespace XWX\Common\Validate\Rule;


use XWX\Common\XReturn;

class Rule_Func extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        $r = call_user_func($this->getArgs(0), $val);
        if ($r instanceof XReturn)
        {
            //pass
        }
        else
        {
            throw new \Exception('return type error');
        }


        return $r;
    }
}