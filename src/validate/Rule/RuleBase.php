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
    private $pub_errs_msg__default = [
        'alpha' => ':fieldName只能是字母',
        'alphanumline' => ':fieldName只能是字母数字下划线',
        'between' => ':fieldName只能在 :arg0 - :arg1 之间',
        'decimal' => ':fieldName只能是小数',
        'datebefore' => ':fieldName必须在日期 :arg0 之前',
        'dateafter' => ':fieldName必须在日期 :arg0 之后',
        'equal' => ':fieldName必须等于:arg0',
        'float' => ':fieldName只能是浮点数',
        'func' => ':fieldName自定义验证失败',
        'integer' => ':fieldName只能是整数',
        'isip' => ':fieldName不是有效的IP地址',
        'isjson' => ':fieldName不是有效的json格式',
        'lenmax' => ':fieldName长度不能超过:arg0',
        'lenmin' => ':fieldName长度不能小于:arg0',
        'lenbetween' => ':fieldName的长度只能在 :arg0 - :arg1 之间',
        'money' => ':fieldName必须是合法的金额',
        'max' => ':fieldName的值不能大于:arg0',
        'min' => ':fieldName的值不能小于:arg0',
        'regex' => ':fieldName不符合指定规则',
        'required' => '必须填写',
        'url' => ':fieldName必须是合法的网址',
    ];

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
        $err_msg = $this->pub_err_msg;
        if (H::funcStrIsNullOrEmpty($err_msg))
        {
            $class_name = get_class($this);
            $key = explode('_', $class_name)[1];
            $key = H::funcStrToLower($key);

            $err_msg = H::funcArrayGet($this->pub_errs_msg__default, $key);
        }

        //替换arg0,arg1等参数
        foreach ($this->getArgs() as $key => $arg)
        {
            if (is_string($arg))
            {
                $err_msg = str_replace(":arg{$key}", $arg, $err_msg);
            }
        }

        return $err_msg;
    }


    /**
     * 设置默认错误提示信息
     *
     * @param array $errs_msg
     */
    public function setErrsMsgDefault(array $errs_msg)
    {
        foreach ($errs_msg as $k => $v)
        {
            if (array_key_exists($k, $this->pub_errs_msg__default))
            {
                $this->pub_errs_msg__default[$k] = $v;
            }
        }
    }


    /**
     * 验证
     *
     * @param $val
     * @return XReturn
     */
    abstract public function funcValidate($val): XReturn;
}