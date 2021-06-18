<?php


namespace XWX\Common\Util;


class Str
{
    /**
     * 字符串转INT
     *
     * @param $s
     * @param int $def
     * @return int
     */
    static function toInt($s, $def = 0): int
    {
        if (is_numeric($s))
        {
            return intval($s);
        }
        return $def;
    }

    /**
     * 字符串转float
     *
     * @param $s
     * @param float $def
     * @return float
     */
    static function toFloat($s, $def = 0.0): float
    {
        if (is_numeric($s))
        {
            return floatval($s);
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
    static function maxLen($s, $max)
    {
        $s_len = static::len($s);
        if ($s_len < $max)
        {
            return $s;
        }

        return mb_substr($s, 0, $max);
    }

    /**
     * 字段串长度
     *
     * @param $s
     * @return int
     */
    static function len($s)
    {
        return mb_strlen($s);
    }


    /**
     * 包含
     *
     * @param $s
     * @param $contains
     * @return bool
     */
    static function contains($s, $contains)
    {
        if (strpos($s, $contains) === false)
        {
            return false;
        }

        return true;
    }


    /**
     * 是否以 $end 结尾
     *
     * @param $s
     * @param $end
     * @return bool
     */
    static function endsWith($s, $end)
    {
        if (static::isNullOrEmpty($end))
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
    static function startsWith($s, $start)
    {
        if (static::isNullOrEmpty($start))
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
    static function isNullOrEmpty($s)
    {
        if ($s === null)
        {
            return true;
        }
        if ($s === '')
        {
            return true;
        }
        if (is_string($s))
        {
            if (trim($s) === '')
            {
                return true;
            }
        }

        return false;
    }

    /**
     * not empty
     *
     * @param $s
     * @return bool
     */
    static function hasAnyText($s)
    {
        return !static::isNullOrEmpty($s);
    }


    /**
     * MD5 大写
     *
     * @param $s
     * @return string
     */
    static function md5($s)
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
    static function sha1($s)
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
    static function toUpper($s)
    {
        $str = $s;
        if (is_string($str))
        {
            $str = mb_strtoupper($s, 'UTF-8');
        }

        return $str;
    }

    /**
     * 变小写
     *
     * @param $s
     * @return string
     */
    static function toLower($s)
    {
        $str = $s;
        if (is_string($str))
        {
            $str = mb_strtolower($s, 'UTF-8');
        }

        return $str;
    }


    /**
     * 数组转key=val
     *
     * @param $arr
     * @param null $exclude_keys
     * @param bool $do_url_encode
     * @param bool $do_lower_key
     * @param bool $do_sort_key
     * @return string
     */
    static function queryFromArray($arr, $exclude_keys = null
        , $do_url_encode = true, $do_lower_key = false, $do_sort_key = true)
    {
        if ($exclude_keys != null)
        {
            //过滤key
            foreach ($exclude_keys as $key)
            {
                if (array_key_exists($key, $arr))
                {
                    unset($arr[$key]);
                }
            }
        }

        $keys = array_keys($arr);
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

        if (static::hasAnyText($query))
        {
            $query = substr($query, 1, strlen($query));
        }

        return $query;
    }


    /**
     * 下划线转驼峰
     *
     * @param $str
     * @return string
     */
    static function toCamelize($str)
    {
        $separator = '_';
        $str = $separator . str_replace($separator, " ", strtolower($str));

        return ltrim(str_replace(" ", "", ucwords($str)), $separator);
    }


    /**
     * 驼峰转下划线
     * @param $camel_str
     * @return string
     */
    static function toUnCamelize($camel_str)
    {
        $separator = '_';

        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camel_str));
    }


    /**
     * 字符串 分隔显示
     * @param $str
     * @param int $num 多少字符分隔
     * @param string $glue 分隔符
     * @return string
     */
    static function split($str, $num, $glue = ' ')
    {
        if (static::isNullOrEmpty($str))
        {
            return '';
        }

        $code_data = str_split($str, $num);
        return join($glue, $code_data);
    }


    /**
     * 16位数字
     * @return string
     */
    static function idShort()
    {
        return substr(uniqid('', true), 15) . substr(microtime(), 2, 8);
    }
}