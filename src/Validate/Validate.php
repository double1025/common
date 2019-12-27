<?php

namespace XWX\Common\Validate;


use XWX\Common\H;
use XWX\Common\XReturn;

/**
 * 数据验证器
 * Class Validate
 * @package EasySwoole\Validate
 */
class Validate
{
    protected $pub_columns = [];

    protected $pub_errors = [];

    protected $pub_errors_msg__default = [];


    /**
     * Validate constructor.
     * @param array $errs_msg__default 自定义默认错误
     */
    public function __construct($errs_msg__default = [])
    {
        $this->pub_errors_msg__default = $errs_msg__default;
    }


    /**
     * @return XReturn[]
     */
    function getErrors()
    {
        return $this->pub_errors;
    }


    /**
     * 添加一个待验证字段
     *
     * @param string $name
     * @return ValidateFunc
     */
    public function addColumn(string $name): ValidateFunc
    {
        $v_func = new ValidateFunc();
        $this->pub_columns[$name] = [
            'v_func' => $v_func
        ];
        return $v_func;
    }

    /**
     * 验证字段是否合法
     *
     * @param array $data 需要验证的keyval
     * @param bool $validate_all false:验证不能立刻终止;true:会遍历所有验证;
     * @return bool
     */
    function validate(array $data, $validate_all = false)
    {
        $errors = [];
        foreach ($this->pub_columns as $key => $item)
        {
            /** @var ValidateFunc $v_func */
            $v_func = $item['v_func'];
            $rules = $v_func->getRules();

            $val = H::funcArrayGet($data, $key);

            //遍历所有验证
            $is_pass = true;
            foreach ($rules as $rule_key => $rule)
            {
                if (count($this->pub_errors_msg__default) > 0)
                {
                    //自定义默认错误提示
                    $rule->setErrsMsgDefault($this->pub_errors_msg__default);
                }

                $r = $rule->funcValidate($val);
                if ($r->err())
                {
                    $is_pass = false;

                    $r->errmsg = str_replace(':fieldName', $key, $r->errmsg);
                    $arg0 = $rule->getArgs(0);
                    if (H::funcStrHasAnyText($arg0))
                    {
                        $r->errmsg = str_replace(':arg0', $arg0, $r->errmsg);
                    }
                    $arg1 = $rule->getArgs(1);
                    if (H::funcStrHasAnyText($arg1))
                    {
                        $r->errmsg = str_replace(':arg1', $arg1, $r->errmsg);
                    }

                    $errors[$key] = $r;

                    break;
                }
            }

            if (!$is_pass)
            {
                //有字段验证不通过并且不需要验证所有字段，立刻终止
                if (!$validate_all)
                {
                    break;
                }
            }
        }


        if (count($errors) > 0)
        {
            $this->pub_errors = $errors;
            return false;
        }


        return true;
    }


}
