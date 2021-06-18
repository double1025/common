<?php


namespace XWX\Common\Util;


class Arr
{
    /**
     * 根据key获取数组值，若无key，则null
     *
     * @param $arr
     * @param $key
     * @param null $def
     * @return mixed|null
     */
    static function get(&$arr, $key, $def = null)
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
    static function rand(&$arr)
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
     * @param array $keys
     * @return array
     */
    static function del(&$arr, $keys = [])
    {
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
     * @param array $arr
     * @param string $key
     * @param int $sort 排序方式，SORT_ASC：顺序；SORT_DESC：倒序；
     */
    static function order(&$arr, $key, $sort)
    {
        $arr_val = array_column($arr, $key);
        array_multisort($arr_val, $sort, $arr);
    }
}