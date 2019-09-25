<?php

namespace XWX\Common;


use XWX\Common\Traits\Helpers\TraitHelper;
use XWX\Common\Traits\Helpers\TraitHelperArray;
use XWX\Common\Traits\Helpers\TraitHelperStr;

/**
 * 帮助类
 *
 * Class H
 * @package XWX\Common
 */
class H
{
    use TraitHelper, TraitHelperStr, TraitHelperArray;


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
}