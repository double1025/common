<?php

namespace XWX\Common;

/**
 * 返回类
 *
 * Class CommonReturn
 * @package XWX\Common
 */
class XReturn
{
    public $errcode = -123456;
    public $errmsg = '';

    /**
     * @var array
     */
    public $return_data = [];


    public function getData($key = null)
    {
        if (H::funcStrHasAnyText($key))
        {
            return H::funcArrayGet($this->return_data, $key);
        }

        return $this->return_data;
    }

    public function setData($key, $val)
    {
        $this->return_data[$key] = $val;
    }


    public function setOK()
    {
        $this->errcode = 0;
    }


    public function ok(): bool
    {
        return $this->errcode == 0;
    }

    public function err(): bool
    {
        return $this->errcode != 0;
    }
}