<?php

namespace XWX\Common;

use Carbon\Carbon;

/**
 * 返回类
 *
 * Class CommonReturn
 * @package XWX\Common
 */
class XUrl extends XEntity
{
    protected $http_root; //域名
    protected $page_name = '';//页面名
    protected $url = ''; //URL
    protected $query_data = []; //URL带的参数


    public function __construct($data = null)
    {
        $this->init($data);
    }


    /**
     * 初始化
     * @param $url
     */
    public function init($url)
    {
        //https://www.baidu.com/v?wd=xxx
        //_template/head/head.wx.jssdk.html?dev=true
        $data = parse_url($url);


        $scheme = H::funcArrayGet($data, 'scheme');
        $host = H::funcArrayGet($data, 'host');
        $path = H::funcArrayGet($data, 'path');

        if (H::funcStrHasAnyText($scheme) && H::funcStrHasAnyText($host))
        {
            $this->http_root = "{$scheme}://{$host}";
        }


        $this->url = "{$this->http_root}{$path}";

        $url_data = explode('/', $this->url);
        $this->page_name = array_pop($url_data);

        //url参数
        $query = H::funcArrayGet($data, 'query');
        if (H::funcStrHasAnyText($query))
        {
            $querys = explode('&', $query);
            foreach ($querys as $v)
            {
                $q_data = explode('=', $v);

                $this->query_data[$q_data[0]] = $q_data[1];
            }
        }
    }

    public function http_root()
    {
        return $this->http_root;
    }

    public function page_name()
    {
        return $this->page_name;
    }

    public function url()
    {
        return $this->url;
    }

    public function getQuery($key = null)
    {
        if ($key !== null)
        {
            return H::funcArrayGet($this->query_data, $key);
        }

        return $this->query_data;
    }
}