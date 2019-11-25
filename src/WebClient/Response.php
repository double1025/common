<?php

namespace XWX\Common\WebClient;


use XWX\Common\H;
use XWX\Common\XReturn;

class Response extends XReturn
{
    protected $cookies = [];
    protected $body = '';
    protected $resInfo = [];
    protected $headers = [];

    function __construct()
    {
    }


    /**
     * cookie
     * @param null $key
     * @return array|mixed|null
     */
    public function getCookie($key = null)
    {
        if (H::funcStrHasAnyText($key))
        {
            return H::funcArrayGet($this->cookies, $key);
        }

        return $this->cookies;
    }


    /**
     * @return bool|string
     */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * 客户端信息
     * @param null $key
     * @return array|mixed
     */
    public function getResInfo($key = null)
    {
        if (H::funcStrHasAnyText($key))
        {
            return H::funcArrayGet($this->resInfo, $key);
        }

        return $this->resInfo;
    }

    /**
     * 请求头
     * @param null $key
     * @return array|mixed|null
     */
    public function getHeader($key = null)
    {
        if (H::funcStrHasAnyText($key))
        {
            return H::funcArrayGet($this->headers, $key);
        }

        return $this->headers;
    }
}