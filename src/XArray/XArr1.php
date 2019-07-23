<?php

namespace XWX\Common\XArray;


class XArr1 extends XArrBase
{
    public function where($where_prop, $where_val, $operator = '=')
    {
        $arr = $this->get();

        return $this->funcCall($arr);
    }


    public function select($keys, $only_show_val = false)
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


        return $this->funcCall($arr_new);
    }
}