<?php

namespace XWX\Common\validate\Rule;


use XWX\Common\H;
use XWX\Common\XReturn;

class Rule_Decimal extends RuleBase
{
    public function funcValidate($val): XReturn
    {
        $is_pass = false;

        $arg = $this->getArgs(0);
        if (H::funcStrIsNullOrEmpty($arg))
        {
            $is_pass = filter_var($val, FILTER_VALIDATE_FLOAT) !== false;
        }
        elseif (intval($arg) === 0)
        {
            // 容错处理 如果小数点后设置0位 则验整数
            $is_pass = filter_var($val, FILTER_VALIDATE_INT) !== false;
        }
        else
        {
            $regex = '/^(0|[1-9]+[0-9]*)(.[0-9]{1,' . $arg . '})?$/';
            $is_pass = preg_match($regex, $val);
        }

        if (!$is_pass)
        {
            return $this->funcGetR(-1033, $this->getErrMsg());
        }

        return $this->funcGetR(0);
    }
}