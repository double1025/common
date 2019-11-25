<?php

namespace XWX\Common;

/**
 * 返回类
 *
 * @property $scheme;
 * @property $host;
 * @property $path;
 *
 * Class CommonReturn
 * @package XWX\Common
 */
class XUrl extends XEntity
{
    protected $url_original;//原URL
    protected $url = ''; //URL
    protected $root; //域名
    protected $page_name = '';//页面名
    protected $query_data = []; //URL带的参数
    //
    protected $scheme = 'http';
    protected $host; //www.baidu.com
    protected $port;
    protected $path;
    protected $query;
    protected $isSSL = false;


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
        $this->url_original = $url;

        //https://www.baidu.com/v?wd=xxx
        //_template/head/head.wx.jssdk.html?dev=true
        $data = parse_url($url);


        $this->scheme = H::funcArrayGet($data, 'scheme');
        $this->host = H::funcArrayGet($data, 'host');
        $this->port = H::funcArrayGet($data, 'port');
        $this->path = H::funcArrayGet($data, 'path');
        //url参数
        $this->query = H::funcArrayGet($data, 'query');


        if ($this->scheme == 'https')
        {
            $this->isSSL = true;
        }

        if (H::funcStrHasAnyText($this->scheme) && H::funcStrHasAnyText($this->host))
        {
            $this->root = "{$this->scheme}://{$this->host}";
        }


        $this->url = "{$this->root}{$this->path}";

        $url_data = explode('/', $this->path);
        $this->page_name = array_pop($url_data);

        if (H::funcStrHasAnyText($this->query))
        {
            $querys = explode('&', $this->query);
            foreach ($querys as $v)
            {
                $q_data = explode('=', $v);

                $this->query_data[$q_data[0]] = $q_data[1];
            }
        }
    }


    /**
     * 端口
     * @return mixed
     */
    public function port()
    {
        if (H::funcStrIsNullOrEmpty($this->port))
        {
            if ($this->isSSL)
            {
                $this->port = 443;
            }
            else
            {
                $this->port = 80;
            }
        }

        return $this->port;
    }


    public function pathAndQuery()
    {
        $path = $this->path;
        if (H::funcStrIsNullOrEmpty($path))
        {
            $path = '/';
        }

        $query = $this->query;
        if (H::funcStrIsNullOrEmpty($query))
        {
            return $path;
        }
        else
        {
            return "{$path}?{$query}";
        }
    }


    /**
     * 是否https请求
     * @return bool
     */
    public function isSSL()
    {
        return $this->isSSL;
    }

    /**
     * 域名
     * @return string
     */
    public function root()
    {
        return $this->root;
    }

    /**
     * 页面名称
     * @return string
     */
    public function page_name()
    {
        return $this->page_name;
    }


    /**
     * 原URL
     * @return string
     */
    public function url_original()
    {
        return $this->url_original;
    }

    /**
     * 去掉参数的URL
     * @return string
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * URL参数
     * @param null $key
     * @return array|mixed|null
     */
    public function getQuery($key = null)
    {
        if ($key !== null)
        {
            return H::funcArrayGet($this->query_data, $key);
        }

        return $this->query_data;
    }
}