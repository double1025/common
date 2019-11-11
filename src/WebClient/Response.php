<?php

namespace XWX\Common\WebClient;


use XWX\Common\H;
use XWX\Common\XReturn;

class Response extends XReturn
{
    private $cookies = [];
    private $body = '';
    private $curlInfo = [];
    private $headerLine = '';

    function __construct($rawResponse, $curlResource)
    {
        $this->curlInfo = curl_getinfo($curlResource);
        $this->errcode = curl_errno($curlResource);
        $this->errmsg = curl_error($curlResource);

        if ($this->err())
        {
            throw new \Exception($this->errmsg);
        }

        $this->headerLine = substr($rawResponse, 0, $this->curlInfo['header_size']);
        $this->body = substr($rawResponse, $this->curlInfo['header_size']);
        //处理头部中的cookie
        preg_match_all("/Set-Cookie:(.*)\n/U", $this->headerLine, $ret);
        if (!empty($ret[0]))
        {
            foreach ($ret[0] as $item)
            {
                preg_match('/(Cookie: )(.*?)(\r\n)/', $item, $ret);
                $ret = explode('=', trim($ret[2], ';'));
                $cookie = new Cookie();
                $cookie->setName($ret[0]);
                $cookie->setValue($ret[1]);
                $this->cookies[$ret[0]] = $cookie;
            }
        }
        curl_close($curlResource);
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function getCookie($name): ?Cookie
    {
        if (isset($this->cookies[$name]))
        {
            return $this->cookies[$name];
        }
        else
        {
            return null;
        }
    }

    /**
     * @return bool|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array|mixed
     */
    public function getCurlInfo($key = null)
    {
        if (H::funcStrHasAnyText($key))
        {
            return H::funcArrayGet($this->curlInfo, $key);
        }

        return $this->curlInfo;
    }

    /**
     * @return bool|string
     */
    public function getHeaderLine()
    {
        return $this->headerLine;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getBody();
    }
}