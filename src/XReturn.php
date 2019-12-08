<?php

namespace XWX\Common;

use Carbon\Carbon;

/**
 * 返回类
 * @property $errcode;
 * @property $errmsg;
 *
 * Class CommonReturn
 * @package XWX\Common
 */
class XReturn extends XEntity
{
    protected $errcode = -123456;
    protected $errmsg = '';

    /**
     * @var array
     */
    protected $return_data = [];


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
        $this->setVal('errcode', 0);
    }


    public function ok(): bool
    {
        return $this->errcode == 0;
    }

    public function err(): bool
    {
        return $this->errcode != 0;
    }


    protected function funcGetOriginalData()
    {
        $data = [];
        foreach ($this as $key => $val)
        {
            if (in_array($key, ['return_data']))
            {
                continue;
            }

            $data[$key] = $val;
        }

        foreach ($this->getData() as $key => $val)
        {
            $data[$key] = $val;
        }

        return $data;
    }
}