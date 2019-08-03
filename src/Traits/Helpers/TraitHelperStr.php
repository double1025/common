<?php

namespace XWX\Common\Traits\Helpers;


trait TraitHelperStr
{
    /**
     * 字符串转INT
     *
     * @param $s
     * @param int $def
     * @return int
     */
    static function funcStrToInt($s, $def = 0): int
    {
        if (is_numeric($s))
        {
            return intval($s);
        }
        return $def;
    }


    /**
     * 字符串截取$max长度
     *
     * @param $s
     * @param $max
     * @return bool|string
     */
    static function funcStrMaxLen($s, $max)
    {
        $s_len = strlen($s);
        if ($s_len < $max)
        {
            return $s;
        }

        return substr($s, 0, $max);
    }

    /**
     * 是否以 $end 结尾
     *
     * @param $s
     * @param $end
     * @return bool
     */
    static function funcStrEndsWith($s, $end)
    {
        if (static::funcStrIsNullOrEmpty($end))
        {
            return true;
        }


        return (($temp = strlen($s) - strlen($end)) >= 0 && strpos($s, $end, $temp) !== FALSE);
    }

    /**
     * 是否以 $start 开头
     *
     * @param $s
     * @param $start
     * @return bool
     */
    static function funcStrStartsWith($s, $start)
    {
        if (static::funcStrIsNullOrEmpty($start))
        {
            return true;
        }

        if (strpos($s, $start) === 0)
        {
            return true;
        }

        return false;
    }

    /**
     * null or empty
     *
     * @param $s
     * @return bool
     */
    static function funcStrIsNullOrEmpty($s)
    {
        if ($s === null)
        {
            return true;
        }
        if ($s === '')
        {
            return true;
        }
        if (trim($s) === '')
        {
            return true;
        }

        return false;
    }

    /**
     * not empty
     *
     * @param $s
     * @return bool
     */
    static function funcStrHasAnyText($s)
    {
        return !static::funcStrIsNullOrEmpty($s);
    }


    /**
     * MD5 大写
     *
     * @param $s
     * @return string
     */
    static function funcStrMD5($s)
    {
        $str = md5($s);
        $STR = strtoupper($str);

        return $STR;
    }

    /**
     * SHA1 大写
     *
     * @param $s
     * @return string
     */
    static function funcStrSHA1($s)
    {
        $str = sha1($s);
        $STR = strtoupper($str);

        return $STR;
    }


    /**
     * 变大写
     *
     * @param $s
     * @return string
     */
    static function funcStrToUpper($s)
    {
        $str = $s;
        if (is_string($str))
        {
            $str = strtoupper($s);
        }

        return $str;
    }

    /**
     * 变小写
     *
     * @param $s
     * @return string
     */
    static function funcStrToLower($s)
    {
        $str = $s;
        if (is_string($str))
        {
            $str = strtolower($s);
        }

        return $str;
    }


    /**
     * 数组转key=val
     *
     * @param $arr
     * @param null $exclude_list
     * @param bool $do_url_encode
     * @param bool $do_lower_key
     * @param bool $do_sort_key
     * @return string
     */
    static function funcStrQueryFromArray($arr, $exclude_list = null
        , $do_url_encode = true, $do_lower_key = false, $do_sort_key = true)
    {
        $keys = array_keys(array_except($arr, $exclude_list));
        if ($do_sort_key)
        {
            sort($keys);
        }

        $query = '';
        foreach ($keys as $k)
        {
            if ($do_url_encode)
            {
                $query .= "&{$k}=" . urlencode($arr[$k]);
            }
            else
            {
                $query .= "&{$k}=" . $arr[$k];
            }
        }
//        $query = funcStrReduce1($query);

        return $query;
    }
}