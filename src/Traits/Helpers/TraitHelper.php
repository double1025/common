<?php

namespace XWX\Common\Traits\Helpers;


use App\X\XContext;

trait TraitHelper
{
    /**
     * 每隔N秒更新一次
     *
     * @return string
     */
    function funcGetV()
    {
        return (int)(time() / (60 * 10)) . 'a';
    }

    /**
     * 获取唯一ID
     *
     * @param string $prefix
     * @return string
     * @throws \Exception
     */
    function funcGetID($prefix = '')
    {
        return uniqid(str_replace('_', '-', $prefix)) . self::funcGetOrderID();
    }

    /**
     * 获取唯一订单ID
     *
     * @return int
     * @throws \Exception
     */
    function funcGetOrderID()
    {
        return date('YmdHis') . uniqid() . random_int(10000, 99999);
    }


    function now()
    {
        return \Carbon::now();
    }

    function today()
    {
        return \Carbon::today();
    }
}