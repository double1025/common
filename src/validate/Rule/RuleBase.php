<?php

namespace XWX\Common\validate\Rule;


abstract class RuleBase
{
    private $pub_val; //值
    private $pub_rule_data; //验证参数，可以是数组


    public function __construct($val, $data)
    {
        $this->pub_val = $val;
        $this->pub_rule_data = $data;
    }

    public function getVal()
    {
        return $this->pub_val;
    }

    public function getRuleData()
    {
        return $this->pub_rule_data;
    }


    abstract public function funcValidate();
}