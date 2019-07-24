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
    public $data = [];


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