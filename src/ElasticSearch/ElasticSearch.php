<?php

namespace XWX\Common\ElasticSearch;


use GuzzleHttp\Client;
use XWX\Common\ElasticSearch\server\Index;

class ElasticSearch
{
    private $pub_host; //链接，例：http:127.0.0.1:9200/
    private $pub_client; //请求客户端

    static function funcIns($host)
    {
        $app = new static();

        $app->pub_host = $host;


        return $app;
    }


    /**
     * 更改请求客户端
     *
     * @param $client
     * @return ElasticSearch
     */
    public function setWebClient(Client $client)
    {
        $this->pub_client = $client;

        return $this;
    }

    /**
     * Guzzle
     * @return Client
     * @throws \Exception
     */
    public function getWebClient(): Client
    {
        if (!isset($this->pub_client))
        {
            throw new \Exception('not set client');
        }


        return $this->pub_client;
    }


    /**
     * 域名
     *
     * @return string
     */
    public function getHost()
    {
        return $this->pub_host;
    }

    public function funcGetUrl($suffix)
    {
        return "{$this->getHost()}{$suffix}";
    }


    /**
     * 索引服务
     * @return Index
     */
    function index()
    {
        $app = Index::funcIns($this);
        return $app;
    }
}