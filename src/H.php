<?php

namespace XWX\Common;


use XWX\Common\Traits\Helpers\TraitHelper;
use XWX\Common\Traits\Helpers\TraitHelperArray;
use XWX\Common\Traits\Helpers\TraitHelperCarbon;
use XWX\Common\Traits\Helpers\TraitHelperStr;

/**
 * 帮助类
 *
 * Class H
 * @package XWX\Common
 */
class H
{
    use TraitHelper, TraitHelperStr, TraitHelperArray, TraitHelperCarbon;


    static function funcIsWin()
    {
        $w = strtoupper(substr(PHP_OS, 0, 3));

        return $w === 'WIN';
    }


    /**
     * 转字符串
     *
     * @param $obj
     * @return string
     */
    static function funcToStr($obj)
    {
        return json_encode($obj, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
    }


    /**
     * 两点之间的距离（单位：米）
     *
     * @param $lng1
     * @param $lat1
     * @param $lng2
     * @param $lat2
     * @param int $decimal *精确x小位
     * @return float
     */
    static function funcCityDistance($lng1, $lat1, $lng2, $lat2, $decimal = 2)
    {
        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI = pi();

        $radLat1 = $lat1 * $PI / 180.0;
        $radLat2 = $lat2 * $PI / 180.0;

        $radLng1 = $lng1 * $PI / 180.0;
        $radLng2 = $lng2 * $PI / 180.0;

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $distance = $distance * $EARTH_RADIUS;
//        $distance = round($distance * 10000) / 10000;

        return round($distance * 1000, $decimal);
    }
}