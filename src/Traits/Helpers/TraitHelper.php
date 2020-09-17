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
     * 短号码（非唯一）
     *
     * @param string $prefix 前缀
     * @param int $len 随机串长度
     * @param int $rand_count 随机字母个数
     * @return string
     */
    static function funcGetNumShort($prefix = '', $len = 4, $rand_count = 0)
    {
        //生成最小、最大随机数
        $min = "1";
        $max = "9";
        for ($i = 0; $i < ($len - 1); $i++)
        {
            $min .= '0';
            $max .= '9';
        }

        $id = (string)mt_rand(self::funcStrToInt($min), self::funcStrToInt($max));

        //随机插入数字
        $id_new = $id;
        for ($i = 0; $i < $rand_count; $i++)
        {
            $c = chr(rand(65, 90));

            $index = rand(0, strlen($id_new));
            $start_str = substr($id_new, 0, $index);
            $end_str = substr($id_new, $index);

            $id_new = "{$start_str}{$c}{$end_str}";
        }

        //前缀
        if (self::funcStrHasAnyText($prefix))
        {
            $id_new = $prefix . $id_new;
        }


        return $id_new;
    }

    /**
     * 短号码（唯一）
     *
     * @param string $prefix 前缀
     * @param int $rand_count 随机字母个数
     * @return string
     */
    static function funcGetNum($prefix = '', $rand_count = 1)
    {
        $id = self::now()->timestamp;

        //随机插入数字
        $id_new = $id;
        for ($i = 0; $i < $rand_count; $i++)
        {
            $c = chr(rand(65, 90));

            $index = rand(0, strlen($id_new));
            $start_str = substr($id_new, 0, $index);
            $end_str = substr($id_new, $index);

            $id_new = "{$start_str}{$c}{$end_str}";
        }

        //前缀
        if (self::funcStrHasAnyText($prefix))
        {
            $id_new = $prefix . $id_new;
        }


        return $id_new;
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