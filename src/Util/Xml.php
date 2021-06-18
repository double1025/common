<?php


namespace XWX\Common\Util;


class Xml
{
    /**
     * xml字段串转数据
     * @param $xml
     * @return mixed
     */
    static function toArr($xml)
    {
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * 数组转xml
     * @param $arr
     * @param string $tag
     * @return \SimpleXMLElement
     */
    static function arrToXml($arr, $tag = 'xml')
    {
        $xml_str = self::arrToXmlStr($arr);
        $xml_str = "<{$tag}>{$xml_str}</{$tag}>";

        return simplexml_load_string($xml_str);
    }

    /**
     * 数组转xml字符串
     * @param $arr
     * @return string
     */
    static protected function arrToXmlStr($arr)
    {
        $xml = '';
        foreach ($arr as $key => $val)
        {
            $xml .= "<{$key}>";

            if ((is_array($val) || is_object($val)))
            {
                $xml .= self::arrToXmlStr((array)$val);
            }
            else
            {
                $xml .= is_numeric($val) ? $val : sprintf('<![CDATA[%s]]>', $val);
            }

            $xml .= "</{$key}>";
        }

        return $xml;
    }
}