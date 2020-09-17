<?php

namespace XWX\Common\ElasticSearch\server;


use XWX\Common\ElasticSearch\ElasticSearch;
use XWX\Common\H;
use XWX\Common\XReturn;

class ServerBase
{
    const method_post = 'post';
    const method_get = 'get';

    private $pub_es;

    static function funcIns(ElasticSearch $es)
    {
        $app = new static();

        $app->pub_es = $es;

        return $app;
    }


    /**
     * @return ElasticSearch
     */
    public function getES()
    {
        return $this->pub_es;
    }

    public function funcGetUrl($suffix)
    {
        return $this->getES()->funcGetUrl($suffix);
    }


    /**
     * @return \GuzzleHttp\Client
     * @throws \Exception
     */
    public function getWebClient()
    {
        return $this->getES()->getWebClient();
    }


    public function funcRetrun($method, $url, $option = [])
    {
        $r = new XReturn();
        $return_str = "";
        try
        {
            /** @var \Psr\Http\Message\ResponseInterface $res */
            $res = $this->getWebClient()->$method($url, $option);

            $r->errcode = 0;

            $return_str = $res->getBody()->getContents();
        }
        catch (\GuzzleHttp\Exception\RequestException $ex)
        {
            $return_str = $ex->getResponse()->getBody()->getContents();
        }


        $return_json = json_decode($return_str, true);

        $r->setData('return_json', $return_json);
        if (array_key_exists('error', $return_json))
        {
            //错误
            $error = H::funcArrayGet($return_json, 'error');

            $errcode = H::funcArrayGet($return_json, 'status', -123456);
            $r->errcode = $errcode;
            $r->errmsg = H::funcArrayGet($error, 'reason');
        }


        return $r;
    }
}