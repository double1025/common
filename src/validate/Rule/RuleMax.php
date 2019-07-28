<?php

namespace XWX\Common\validate\Rule;


use XWX\Common\Helper;

class RuleMax extends RuleBase
{
    public function funcValidate()
    {
        if (!is_numeric($this->getVal()))
        {
            return false;
        }

        $val = Helper::funcInsStatic()->funcStrToInt($this->getVal());
        if ($this->getVal() > $this->getRuleData())
        {
            return false;
        }

        return true;
    }
}