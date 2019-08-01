<?php

namespace XWX\Common\Validate\Rule;


use XWX\Common\H;
use XWX\Common\Traits\TraitCommon;
use XWX\Common\XReturn;

abstract class RuleBase
{
    use TraitCommon;

    private $pub_args;
    private $pub_err_msg;


    public function __construct(array & $args, $msg = null)
    {
        $this->pub_args = $args;
        $this->pub_err_msg = $msg;
    }

    /**
     * 规则参数
     *
     * @param null $key
     * @return array|mixed|null
     */
    public function getArgs($key = null)
    {
        if (H::funcStrHasAnyText($key))
        {
            return H::funcArrayGet($this->pub_args, $key);
        }

        return $this->pub_args;
    }

    /**
     * 验证不通过提示
     *
     * @return string
     */
    public function getErrMsg(): string
    {
        return $this->pub_err_msg;
    }


    /**
     * 验证
     *
     * @param $val
     * @return mixed
     */
    abstract public function funcValidate($val): XReturn;
}