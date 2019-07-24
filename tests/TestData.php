<?php

namespace Tests;


use XWX\Common\Helper;

class TestData
{
    public $desc; //说明
    private $data = [];//测试条件或者期望结果


    static public function funcGet($desc)
    {
        $td = new TestData();
        $td->desc = $desc;

        return $td;
    }


    /**
     * 预设条件
     *
     * @param $key
     * @param $val
     */
    public function setVal($key, $val)
    {
        $this->data[$key] = $val;
    }

    /**
     * 获取条件
     *
     * @param $key
     * @return mixed|null
     */
    public function getVal($key)
    {
        if ($key == null)
        {
            return $this->data;
        }

        $h = new Helper();
        return $h->funcArrayGet($this->data, $key);
    }


    /**
     * @param $key
     * @return bool
     */
    public function keyExists($key)
    {
        return array_key_exists($key, $this->data);
    }
}