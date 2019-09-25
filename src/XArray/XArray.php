<?php

namespace XWX\Common\XArray;


use XWX\Common\H;
use XWX\Common\Traits\TraitIns;

class XArray
{
    private $pub_arr;
    private $pub_is_arr1 = 0;


    /**
     * 初始化
     *
     * @param $arr
     * @return XArray
     */
    static public function funcIns(& $arr)
    {
        if ($arr === null || count($arr) <= 0)
        {
            $arr = [];
        }

        $app = new XArr2();
        if (count($arr) == count($arr, 1))
        {
            //1维数组
            $app = new XArr1($arr);

            $app->pub_is_arr1 = 1;
        }

        $app->pub_arr = $arr;


        return $app;
    }


    /**
     * 是1维数组
     *
     * @return bool
     */
    function isArr1()
    {
        return $this->pub_is_arr1 == 1;
    }


    /**
     * 用于链式调用，操作自己
     *
     * @param $arr
     * @return XArray
     */
    protected function funcCall(& $arr)
    {
        $app = self::funcIns($arr);

        return $app;
    }


    /**
     * 获取全部数组
     *
     * @param null $key
     * @return mixed
     */
    public function get($key = null)
    {
        if ($key != null)
        {
            return H::funcToStr($this->pub_arr, $key);
        }

        return $this->pub_arr;
    }

    /**
     * 获取第一项
     *
     * @return mixed|null
     */
    public function first()
    {
        if (count($this->get()) <= 0)
        {
            return null;
        }

        $str = null;
        foreach ($this->get() as $index => $item)
        {
            $str = $item;
            break;
        }

        return $str;
    }

    function toJson(): string
    {
        return H::funcToStr($this->get());
    }


    /**
     * 数组去重取唯一的值
     *
     * @return XArray
     */
    public function unique()
    {
        $arr_new = array_unique($this->get());

        return $this->funcCall($arr_new);
    }

    /**
     * 自定义过滤器
     *
     * @param callable $func
     * @return XArray
     */
    public function filter(callable $func)
    {
        $arr = [];
        foreach ($this->get() as $index => $item)
        {
            if ($func($index, $item))
            {
                $arr[] = $item;
            }
        }

        return $this->funcCall($arr);
    }


    /**
     * 条件筛选
     *
     * @param $where_prop *条件
     * @param $where_val *值
     * @param string|callable $operator *运算方式或者自定义函数
     * 自定义函数($where_val,列表值)
     *
     * @return XArray
     */
    function where($where_prop, $where_val, $operator = '=')
    {
        $arr = $this->get();

        return $this->funcCall($arr);
    }

    /**
     * 列筛选
     *
     * @param string|array $keys *需要筛选key
     * @param bool $only_show_val *只显示值
     * @return XArray
     */
    function select($keys, $only_show_val = false)
    {
        $arr = $this->get();

        return $this->funcCall($arr);
    }


    /**
     * 排序，注意无法组合使用
     *
     * @param $where_prop *条件
     * @param int $sort *SORT_ASC:顺序;SORT_DESC:倒序;
     * @return XArray
     */
    function order($where_prop, $sort = SORT_ASC)
    {
        $arr = $this->get();

        array_multisort(array_column($arr, $where_prop), $sort, $arr);

        return $this->funcCall($arr);
    }


    /**
     * 数组转字符串
     *
     * @param string $glue
     * @return null
     */
    function implode($glue = ',')
    {
        return null;
    }


    /**
     * 转换成1维数组
     *
     * @return XArray
     */
    function toArr1()
    {
        $arr = $this->get();

        return $this->funcCall($arr);
    }


    /**
     * 值的比较
     *
     * @param $val1
     * @param $val2
     * @param string $operator
     * @return bool
     */
    function compare($val1, $val2, $operator = '=')
    {
        switch ($operator)
        {
            case '!=':
            case '<>':
                return $val1 != $val2;
            case '=':
                return $val1 === $val2;

            case '>':
                return $val1 > $val2;

            case '>=':
                return $val1 >= $val2;

            case '<':
                return $val1 < $val2;

            case '<=':
                return $val1 <= $val2;
        }

        return false;
    }
}