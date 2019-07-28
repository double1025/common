<?php

namespace XWX\Common\Validate;


/**
 * 数据验证器
 * Class Validate
 * @package EasySwoole\Validate
 */
class Validate
{
    protected $columns = [];

    protected $error;

    protected $verifiedData = [];


    function getError(): ?Error
    {
        return $this->error;
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
        $this->columns[$name] = [
            'v_func' => $v_func
        ];
        return $v_func;
    }

    /**
     * 验证字段是否合法
     *
     * @param array $data
     * @return bool
     */
    function validate(array $data)
    {
        $this->verifiedData = [];
        $spl = new SplArray($data);
        foreach ($this->columns as $column => $item)
        {
            /** @var Rule $rule */
            $rule = $item['rule'];
            $rules = $rule->getRuleMap();

            /*
             * 优先检测是否带有optional选项
             * 如果设置了optional又不存在对应字段，则跳过该字段检测
             */
            if (isset($rules['optional']) && !isset($data[$column]))
            {
                $this->verifiedData[$column] = $spl->get($column);
                continue;
            }
            foreach ($rules as $rule => $ruleInfo)
            {
                if (!call_user_func([$this, $rule], $spl, $column, $ruleInfo['arg']))
                {
                    $this->error = new Error($column, $spl->get($column), $item['alias'], $rule, $ruleInfo['msg'], $ruleInfo['arg']);
                    return false;
                }
            }
            $this->verifiedData[$column] = $spl->get($column);
        }
        return true;
    }

    /**
     * 获取验证成功后的数据
     * @return array
     */
    public function getVerifiedData(): array
    {
        return $this->verifiedData;
    }


}
