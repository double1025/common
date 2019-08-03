<?php

namespace XWX\Common\Validate;

use Carbon\Carbon;
use XWX\Common\Validate\Rule\Rule_Alpha;
use XWX\Common\Validate\Rule\Rule_AlphaNumLine;
use XWX\Common\Validate\Rule\Rule_Between;
use XWX\Common\Validate\Rule\Rule_Bool;
use XWX\Common\Validate\Rule\Rule_DateAfter;
use XWX\Common\Validate\Rule\Rule_DateBefore;
use XWX\Common\Validate\Rule\Rule_Decimal;
use XWX\Common\Validate\Rule\Rule_Equal;
use XWX\Common\Validate\Rule\Rule_Float;
use XWX\Common\Validate\Rule\Rule_Func;
use XWX\Common\Validate\Rule\Rule_Integer;
use XWX\Common\Validate\Rule\Rule_IP;
use XWX\Common\Validate\Rule\Rule_IsIP;
use XWX\Common\Validate\Rule\Rule_IsJson;
use XWX\Common\Validate\Rule\Rule_LenBetween;
use XWX\Common\Validate\Rule\Rule_LenMax;
use XWX\Common\Validate\Rule\Rule_LenMin;
use XWX\Common\Validate\Rule\Rule_Max;
use XWX\Common\Validate\Rule\Rule_Min;
use XWX\Common\Validate\Rule\Rule_Regex;
use XWX\Common\Validate\Rule\Rule_Required;
use XWX\Common\Validate\Rule\Rule_Url;
use XWX\Common\Validate\Rule\RuleBase;

/**
 * 校验方法
 *
 * Class ValidateFunc
 * @package XWX\Common\Validate
 */
class ValidateFunc
{
    private $pub_rules = [];

    /**
     * 获取所有验证
     *
     * @return RuleBase[]
     */
    function getRules()
    {
        return $this->pub_rules;
    }


    /**
     * 给定的参数是否是字母 即[a-zA-Z]
     *
     * @param null|string $msg
     * @return $this
     */
    function alpha($msg = null)
    {
        $arg = [];
        $rule = new Rule_Alpha($arg, $msg);

        $this->pub_rules['alpha'] = $rule;

        return $this;
    }

    /**
     * 字母加数字 即[a-zA-Z0-9\_]
     * @param null $msg
     * @return $this
     */
    function alphaNumLine($msg = null)
    {
        $arg = [];
        $rule = new Rule_AlphaNumLine($arg, $msg);

        $this->pub_rules['alphaNum'] = $rule;

        return $this;
    }


    /**
     * 给定的参数是否在 $min $max 之间
     *
     * @param integer $min 最小值
     * @param integer $max 最大值
     * @param null|string $msg
     * @return $this
     */
    function between($min, $max, $msg = null)
    {
        $arg = [$min, $max];
        $rule = new Rule_Between($arg, $msg);

        $this->pub_rules['between'] = $rule;
        return $this;
    }


    /**
     * 是否为小数格式
     *
     * @param null|integer $precision 规定小数点位数 null 为不规定
     * @param null $msg
     * @return $this
     */
    function decimal(?int $precision = null, $msg = null)
    {
        $arg = [$precision];
        $rule = new Rule_Decimal($arg, $msg);

        $this->pub_rules['decimal'] = $rule;
        return $this;
    }

    /**
     * 是否在某日期之前
     * $val < $date
     *
     * @param Carbon $date
     * @param null $msg
     * @return $this
     */
    function dateBefore(Carbon $date, $msg = null)
    {
        $arg = [$date];
        $rule = new Rule_DateBefore($arg, $msg);

        $this->pub_rules['dateBefore'] = $rule;
        return $this;
    }

    /**
     * 给定参数是否在某日期之后
     * $val > $date
     *
     * @param Carbon|null $date
     * @param null $msg
     * @return $this
     */
    function dateAfter(Carbon $date = null, $msg = null)
    {
        $arg = [$date];
        $rule = new Rule_DateAfter($arg, $msg);

        $this->pub_rules['dateAfter'] = $rule;
        return $this;
    }

    /**
     * 验证值是否相等
     *
     * @param $compare
     * @param null|string $msg
     * @return $this
     */
    function equal($compare, $msg = null)
    {
        $arg = [$compare];
        $rule = new Rule_Equal($arg, $msg);

        $this->pub_rules['equal'] = $rule;
        return $this;
    }


    /**
     * 调用自定义的闭包验证
     *
     * @param callable $func
     * @param null|string $msg
     * @return $this
     */
    function func(callable $func, $msg = null)
    {
        $arg = [$func];
        $rule = new Rule_Func($arg, $msg);

        $this->pub_rules['func'] = $rule;
        return $this;
    }


    /**
     * 是否一个整数值
     *
     * @param null|string $msg
     * @return $this
     */
    function integer($msg = null)
    {
        $arg = [];
        $rule = new Rule_Integer($arg, $msg);

        $this->pub_rules['integer'] = $rule;
        return $this;
    }

    /**
     * 是否一个有效的IP
     * @param null $msg
     * @return $this
     */
    function isIp($msg = null)
    {
        $arg = [];
        $rule = new Rule_IsIP($arg, $msg);

        $this->pub_rules['isIp'] = $rule;
        return $this;
    }

    /**
     * 有效的JSON格式
     * @param null $msg
     * @return $this
     */
    function isJson($msg = null)
    {
        $arg = [];
        $rule = new Rule_IsJson($arg, $msg);

        $this->pub_rules['isIp'] = $rule;
        return $this;
    }


    /**
     * 验证数组或字符串的长度 < $lengthMax
     * @param int $lengthMax
     * @param null $msg
     * @return $this
     */
    function lenMax(int $lengthMax, $msg = null)
    {
        $arg = [$lengthMax];
        $rule = new Rule_LenMax($arg, $msg);

        $this->pub_rules['lengthMax'] = $rule;
        return $this;
    }

    /**
     * 验证数组或字符串的长度 > $lengthMin
     *
     * @param int $lengthMin
     * @param null $msg
     * @return $this
     */
    function lenMin(int $lengthMin, $msg = null)
    {
        $arg = [$lengthMin];
        $rule = new Rule_LenMin($arg, $msg);

        $this->pub_rules['lengthMin'] = $rule;
        return $this;
    }

    /**
     * 验证数组或字符串的长度是否在一个范围内
     * @param int $min
     * @param int $max
     * @param null $msg
     * @return $this
     */
    function lenBetween(int $min, int $max, $msg = null)
    {
        $arg = [$min, $max];
        $rule = new Rule_LenBetween($arg, $msg);

        $this->pub_rules['lenBetween'] = $rule;
        return $this;
    }

    /**
     * 验证值 > $max
     *
     * @param int $max
     * @param null|string $msg
     * @return $this
     */
    function max(int $max, ?string $msg = null)
    {
        $arg = [$max];
        $rule = new Rule_Max($arg, $msg);

        $this->pub_rules['max'] = $rule;

        return $this;
    }

    /**
     * 验证值 < $min
     * @param int $min
     * @param null|string $msg
     * @return $this
     */
    function min(int $min, ?string $msg = null)
    {
        $arg = [$min];
        $rule = new Rule_Min($arg, $msg);

        $this->pub_rules['min'] = $rule;
        return $this;
    }


    /**
     * 正则表达式验证
     * @param $reg
     * @param null $msg
     * @return $this
     */
    function regex($reg, $msg = null)
    {
        $arg = [$reg];
        $rule = new Rule_Regex($arg, $msg);

        $this->pub_rules['regex'] = $rule;
        return $this;
    }

    /**
     * 必须存在值
     * @param null $msg
     * @return $this
     */
    function required($msg = null)
    {
        $arg = [];
        $rule = new Rule_Required($arg, $msg);

        $this->pub_rules['required'] = $rule;
        return $this;
    }


    /**
     * 值是一个合法的链接
     * @param null $msg
     * @return $this
     */
    function url($msg = null)
    {
        $arg = [];
        $rule = new Rule_Url($arg, $msg);

        $this->pub_rules['url'] = $rule;
        return $this;
    }
}