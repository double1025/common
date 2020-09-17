<?php

namespace XWX\Common\Traits\Helpers;


trait TraitHelperArray
{
    /**
     * 根据key获取数组值，若无key，则null
     *
     * @param $arr
     * @param $key
     * @param null $def
     * @return mixed|null
     */
    static function funcArrayGet(& $arr, $key, $def = null)
    {
        if (is_array($arr))
        {
            if (array_key_exists($key, $arr))
            {
                return $arr[$key];
            }
        }

        return $def;
    }

    /**
     * 打乱数组顺序
     *
     * @param $arr
     * @return array
     */
    static function funcArrayRand(& $arr)
    {
        if (is_array($arr))
        {
            $arr_new = [];
            foreach ($arr as $key => $value)
            {
                $rnd = rand(0, count($arr_new));

                array_splice($arr_new, $rnd, 0, $value);
            }

            return $arr_new;
        }

        return $arr;
    }


    /**
     * 删除数组某一项，并重新排序下标
     * @param array $arr
     * @param $del_key
     * @return array
     */
    static function funcArrayDelByKey(& $arr, $del_keys)
    {
        $keys = [];
        if (is_array($del_keys))
        {
            $keys = $del_keys;
        }
        else
        {
            $keys = [$del_keys];
        }

        foreach ($keys as $key)
        {
            if (array_key_exists($key, $arr))
            {
                unset($arr[$key]);
            }
        }
        $arr = array_values($arr);

        return $arr;
    }


    /**
     * 按某字段排序
     * @param $arr
     * @param $key
     * @param $sort 排序方式，SORT_ASC：顺序；SORT_DESC：倒序；
     */
    static function funcArrayOrderByKey(& $arr, $key, $sort)
    {
        array_multisort(array_column($arr, $key), $sort, $arr);
    }
}