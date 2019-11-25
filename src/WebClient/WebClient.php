<?php

namespace XWX\Common\WebClient;


use XWX\Common\H;
use XWX\Common\XUrl;

class WebClient
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';


    protected $pub_option = [];

    protected $pub_post_data;

    protected $pub_cookies = [];
    protected $pub_headers = [];
    /** @var XUrl */
    protected $pub_url;
    protected $pub_method = WebClient::METHOD_GET;


    function __construct(string $url = null)
    {
        if ($url !== null)
        {
            $this->setUrl($url);
        }

        $this->setConnectTimeout(5);
        $this->setTimeout(10);

        $this->init();
    }


    /**
     * 初始化
     */
    protected function init()
    {
        $this->pub_option = [
            CURLOPT_USERAGENT => "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET4.0C; .NET4.0E)",
            CURLOPT_AUTOREFERER => true, //当根据Location:重定向时，自动设置header中的Referer:信息
            CURLOPT_RETURNTRANSFER => true, //是否将结果返回
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HEADER => true, //是否返回响应头信息
        ];


        $this->setFollowLocation(true);
    }

    public function setUrl(string $url): WebClient
    {
        $this->pub_url = new XUrl($url);
        return $this;
    }


    /**
     * 响应超时
     *
     * @param int $timeout
     * @return WebClient
     */
    public function setTimeout(int $timeout): WebClient
    {
        $this->pub_option[CURLOPT_TIMEOUT] = $timeout;
        return $this;
    }

    /**
     * 连接超时
     *
     * @param int $connectTimeout
     * @return WebClient
     */
    public function setConnectTimeout(int $connectTimeout): WebClient
    {
        $this->pub_option[CURLOPT_CONNECTTIMEOUT] = $connectTimeout;
        return $this;
    }


    /**
     * 设置验证用的SSL证书，证书秘钥文件
     * @param string $sslCafile 证书文件路径
     * @param string $sslKeyFile 秘钥文件路径
     *
     * @return $this
     */
    public function setSslInfo(string $sslCafile, string $sslKeyFile = null)
    {
        $this->pub_option[CURLOPT_SSLCERTTYPE] = 'PEM';
        $this->pub_option[CURLOPT_SSLCERT] = $sslCafile;
        $this->pub_option[CURLOPT_SSLKEYTYPE] = 'PEM';
        $this->pub_option[CURLOPT_SSLKEY] = $sslKeyFile;

        return $this;
    }

    /**
     * 是否允许重写向
     * @param $ok
     * @return $this
     */
    public function setFollowLocation($is_location)
    {
        $this->pub_option[CURLOPT_FOLLOWLOCATION] = $is_location;
        return $this;
    }


    /**
     * 设置请求参数
     *
     * @param array $opt
     * @param bool $is_merge true:和默认参数合并;false:不合并
     * @return WebClient
     */
    public function setOption(array $opt, $is_merge = true): WebClient
    {
        if ($is_merge)
        {
            $this->pub_option = $opt + $this->pub_option;
        }
        else
        {
            $this->pub_option = $opt;
        }

        return $this;
    }


    /**
     * 添加cookie
     *
     * @param Cookie $cookie
     * @return WebClient
     */
    public function addCookie($key, $val): WebClient
    {
        $this->pub_cookies[$key] = $val;

        return $this;
    }

    public function addCookies(array $cookies): WebClient
    {
        $this->pub_cookies = $cookies;
        return $this;
    }

    public function setHeader($key, $val): WebClient
    {
        $this->pub_headers[$key] = $val;

        return $this;
    }

    public function setHeaders(array $headers)
    {
        $this->pub_headers = $headers;

        return $this;
    }


    public function post($data)
    {
        $this->pub_method = WebClient::METHOD_POST;
        $this->pub_post_data = $data;


        $response = $this->exec();

        return $response;
    }


    public function postForm(array $data)
    {
        $this->pub_method = WebClient::METHOD_POST;
        $this->pub_post_data = $data;

        $this->setHeader('Content-Type', 'application/x-www-form-urlencoded');

        $response = $this->exec();

        return $response;
    }

    public function get()
    {
        $this->pub_method = WebClient::METHOD_GET;

        $response = $this->exec();


        return $response;
    }


    protected function exec(): Response
    {
        $client = curl_init();

//        var_dump($this->getOption());
        curl_setopt_array($client, $this->getOption());

        $result = curl_exec($client);

        $res = $this->execAfter($client, $result);

        curl_close($client);


        return $res;
    }


    /**
     * @param $client
     * @param null $result
     * @return Response
     * @throws \Exception
     */
    protected function execAfter($client, $result = null)
    {
        $res = new Response();

        $res->errcode = curl_errno($client);
        $res->errmsg = curl_error($client);
        if ($res->err())
        {
            throw new \Exception($res->errmsg);
        }

        $res->setVal('resInfo', curl_getinfo($client));

        $header_str = substr($result, 0, $res->getResInfo('header_size'));
        if (H::funcStrHasAnyText($header_str))
        {
            $header_arr = explode(PHP_EOL, $header_str);
            $headers = [];
            foreach ($header_arr as $value)
            {
                if (!H::funcStrContains($value, ':'))
                {
                    continue;
                }

                $data = explode(':', $value);
                $headers[H::funcStrToLower($data[0])] = trim($data[1]);
            }
            $res->setVal('headers', $headers);
        }

        //处理头部中的cookie
        preg_match_all("/Set-Cookie:(.*)\n/U", $header_str, $ret);
        if (!empty($ret[0]))
        {
            $cookies = [];
            foreach ($ret[0] as $item)
            {
                preg_match('/(Cookie: )(.*?)(\r\n)/', $item, $ret);
                $ret = explode('=', trim($ret[2], ';'));
                $cookie = new Cookie();
                $cookie->setName($ret[0]);
                $cookie->setValue($ret[1]);

                $cookies[$ret[0]] = $cookie;
            }

            $res->setVal('cookies', $cookies);
        }

        $body = substr($result, $res->resInfo['header_size']);
        $res->setVal('body', $body);

        return $res;
    }


    private function getOption(): array
    {
        $option = $this->pub_option;

        $option[CURLOPT_URL] = $this->pub_url->url_original();
        if ($this->pub_method == self::METHOD_POST)
        {
            //若请求为POST类型，则$option中的优先级最高
            $option[CURLOPT_POST] = true;

            //参数
            if (isset($this->pub_post_data))
            {
                if (is_array($this->pub_post_data))
                {
                    $option[CURLOPT_POSTFIELDS] = http_build_query($this->pub_post_data);
                }
                else
                {
                    $option[CURLOPT_POSTFIELDS] = $this->pub_post_data;
                }
            }
        }


        if (!empty($this->pub_cookies))
        {
            //cookie

            $str = '';
            foreach ($this->pub_cookies as $cookie => $value)
            {
                $str .= "{$cookie}={$value};";
            }
            $option[CURLOPT_COOKIE] = $str;
        }


        if (!empty($this->pub_headers))
        {
            //headers
            $arr = [];
            foreach ($this->pub_headers as $key => $val)
            {
                $arr[] = "{$key}:{$val}";
            }


            $option[CURLOPT_HTTPHEADER] = $arr;
        }


        return $option;
    }
}