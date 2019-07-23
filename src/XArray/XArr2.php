<?php

namespace XWX\Common\XArray;


use XWX\Common\Helper;

class XArr2 extends XArrBase
{
    public function where($where_prop, $where_val, $operator = '=')
    {
        $arr = $this->get();

        $arr_new = array();
        foreach ($arr as $key => $val)
        {
            $val1 = Helper::funcIns()->funcArrayGet($val, $where_prop);
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
     * @return XArrBase
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


        return $this->funcCall($arr_new);
    }


    public function toArr1()
    {
        $arr = $this->get();
        
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
}