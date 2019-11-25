<?php

namespace XWX\Common\WebClient;


use Swoole\Coroutine\Http\Client;


//协程
class WebClientCo extends WebClient
{
    protected function init()
    {
    }


    public function setTimeout(int $timeout): WebClient
    {
        $this->pub_option['timeout'] = $timeout;
        return $this;
    }

    public function setConnectTimeout(int $connectTimeout): WebClient
    {
        $this->pub_option['connect_timeout'] = $connectTimeout;
        return $this;
    }


    public function setFollowLocation($is_location)
    {
        //不支持重定向
        return $this;
    }


    public function setSslInfo(string $sslCafile, string $sslKeyFile = null)
    {
        $this->pub_option['ssl_cafile'] = $sslCafile;
        $this->pub_option['ssl_key_file'] = $sslKeyFile;
        return $this;
    }


    protected function exec(): Response
    {
        $client = new Client($this->pub_url->host, $this->pub_url->port(), $this->pub_url->isSSL());

        $client->set($this->pub_option);
        $client->setMethod($this->pub_method);
        $client->setHeaders($this->pub_headers);
        $client->setCookies($this->pub_cookies + (array)$client->cookies);
        if ($this->pub_method == self::METHOD_POST)
        {
            //POST
            if (is_array($this->pub_post_data))
            {
                foreach ($this->pub_post_data as $key => $item)
                {
                    if ($item instanceof \CURLFile)
                    {
                        $client->addFile($item->getFilename(), $key, $item->getMimeType(), $item->getPostFilename());
                        unset($this->pub_post_data[$key]);
                    }
                }
                $client->setData($this->pub_post_data);
            }
            else if ($this->pub_post_data !== null)
            {
                $client->setData($this->pub_post_data);
            }
        }
        else if ($this->pub_post_data !== null)
        {
            $client->setData($this->pub_post_data);
        }

        if (is_string($this->pub_post_data))
        {
            $this->setHeader('Content-Length', strlen($this->pub_post_data));
        }


        $client->execute($this->pub_url->pathAndQuery());

        $res = $this->execAfter($client);

        return $res;
    }


    protected function execAfter($client, $result = null)
    {
        /** @var Client $client */
        $res = new Response();

        $res->errcode = $client->errCode;
        $res->errmsg = $client->errMsg;
        if ($res->err())
        {
            throw new \Exception($res->errmsg);
        }


        $res->setVal('headers', $client->headers);

        if (count($client->cookies) > 0)
        {
            foreach ($client->cookies as $k => $v)
            {

            }
        }
        $res->setVal('cookies', $client->cookies);
        $res->setVal('body', $client->body);

        return $res;
    }
}