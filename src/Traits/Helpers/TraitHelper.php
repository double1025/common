<?php

namespace XWX\Common\Traits\Helpers;


use Carbon\Carbon;

trait TraitHelper
{
    /**
     * 每隔N秒更新一次
     *
     * @return string
     */
    static function funcGetV()
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
    static function funcGetID($prefix = '')
    {
        return uniqid(str_replace('_', '-', $prefix)) . self::funcGetOrderID();
    }

    /**
     * 获取唯一订单ID
     *
     * @return int
     * @throws \Exception
     */
    static function funcGetOrderID()
    {
        return date('YmdHis') . uniqid() . random_int(10000, 99999);
    }


    /**
     * 现在
     *
     * @return Carbon
     */
    static function now()
    {
        return Carbon::now();
    }

    /**
     * 今天
     *
     * @return Carbon
     */
    static function today()
    {
        return Carbon::today();
    }
}