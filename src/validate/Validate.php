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
            if (!array_key_exists($key, $data))
            {
                //key不存在 next
                continue;
            }


            /** @var ValidateFunc $v_func */
            $v_func = $item['v_func'];
            $rules = $v_func->getRules();

            $val = H::funcArrayGet($data, $key);

            //遍历所有验证
            $is_pass = true;
            foreach ($rules as $rule_key => $rule)
            {
                $r = $rule->funcValidate($val);
                if ($r->err())
                {
                    $is_pass = false;
                    $errors[] = $r;
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
