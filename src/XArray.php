<?php

namespace XWX\Common;


class XArray
{
    private $pub_arr;


    /**
     * 初始化
     *
     * @param $arr
     * @return XArray
     */
    static function funcIns($arr)
    {
        if ($arr == null || count($arr) <= 0)
        {
            $arr = [];
        }

        $app = new XArray();
        $app->pub_arr = $arr;

        return $app;
    }

    /**
     * 用于链式调用，操作自己
     *
     * @param $arr
     * @return XArray
     */
    private function funcCall(& $arr)
    {
        $app = new XArray();
        $app->pub_arr = $arr;

        return $app;
    }


    /**
     * 获取数组
     *
     * @return array
     */
    public function get()
    {
        return $this->pub_arr;
    }

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
        return json_encode($this, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
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
     * @param $where_prop 条件
     * @param $where_val 值
     * @param string|callable $operator 运算方式或者自定义函数
     * 自定义函数($where_val,列表值)
     *
     * @return XArray
     */
    function where($where_prop, $where_val, $operator = '=')
    {
        $arr = $this->get();
        if ($this->isArr1($arr))
        {
            //1维数组，直接返回
            return $this->funcCall($arr);
        }


        $arr_new = array();
        foreach ($arr as $key => $val)
        {
            $val1 = \h::funcArrayGet($val, $where_prop);
            $val2 = $where_val;

            $is_ok = false;
            if (is_callable($operator))
            {
                //匿名函数
                $is_ok = $operator($val1, $val2);
            }
            else
            {
                $is_ok = $this->compare($val1, $val2, $operator);
            }

            if ($is_ok)
            {
                $arr_new[] = $val;
            }
        }


        return $this->funcCall($arr_new);
    }

    /**
     * 列筛选
     *
     * @param string|array $keys 需要筛选key
     * @param bool $only_show_val 只显示值
     * @return XArray
     */
    function select($keys, $only_show_val = false)
    {
        $arr_key = [];
        if (is_string($keys))
        {
            $arr_key = explode(',', $keys);
        }
        else
        {
            $arr_key = $keys;
        }


        $arr = $this->get();

        $arr_new = array();
        foreach ($arr as $key => $val)
        {
            if ($this->isArr1($arr))
            {
                if (in_array($key, $arr_key))
                {
                    if ($only_show_val)
                    {
                        $arr_new[] = $val;
                    }
                    else
                    {
                        $arr_new[$key] = $val;
                    }
                }
            }
            else
            {
                $data = [];
                foreach ($val as $key_2 => $val_2)
                {
                    if (in_array($key_2, $arr_key))
                    {
                        if ($only_show_val)
                        {
                            $data[] = $val_2;
                        }
                        else
                        {
                            $data[$key_2] = $val_2;
                        }
                    }
                }

                $arr_new[] = $data;
            }
        }


        return $this->funcCall($arr_new);
    }


    /**
     * 排序，注意无法组合使用
     *
     * @param $where_prop 条件
     * @param int $sort
     * @return XArray
     */
    function order($where_prop, $sort = SORT_ASC)
    {
        $arr = $this->get();

        array_multisort(array_column($arr, $where_prop), $sort, $arr);

        return $this->funcCall($arr);
    }


    /**
     * 转换成1维数组
     *
     * @return XArray
     */
    function toArr1()
    {
        $arr = $this->get();
        if ($this->isArr1($arr))
        {
            //1维数组，直接返回
            return $this->funcCall($arr);
        }


        $arr_new = [];
        foreach ($arr as $val)
        {
            foreach ($val as $val_2)
            {
                $arr_new[] = $val_2;
            }
        }


        return $this->funcCall($arr_new);
    }


    /**
     * 是1维数组
     *
     * @param $arr
     * @return bool
     */
    function isArr1(& $arr)
    {
        return count($arr) == count($arr, 1);
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
                return $val1 !== $val2;
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