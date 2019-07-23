<?php

namespace XWX\Common\Traits\Helpers;


trait TraitHelperArray
{
    /**
     * 根据key获取数组值，若无key，则null
     *
     * @param type $arr
     * @param type $key
     * @return type
     */
    function funcArrayGet(& $arr, $key)
    {
        if (is_array($arr))
        {
            if (array_key_exists($key, $arr))
            {
                return $arr[$key];
            }
        }

        return null;
    }

    /**
     * 打乱数组顺序
     *
     * @param type $arr
     * @return type
     */
    function funcArrayRand(& $arr)
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

}