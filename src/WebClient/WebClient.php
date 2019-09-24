<?php

namespace XWX\Common\WebClient;


class WebClient
{
    private $pub_curl_option = [
        CURLOPT_CONNECTTIMEOUT => 5, //连接超时
        CURLOPT_TIMEOUT => 10, //处理超时
        CURLOPT_AUTOREFERER => true,
        CURLOPT_USERAGENT => "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET4.0C; .NET4.0E)",
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HEADER => true,
        CURLOPT_AUTOREFERER => true,
    ];

    private $pub_is_post = false;
    private $pub_post_data;

    private $pub_cookies = [];
    private $pub_headers = [];


    function __construct(string $url = null)
    {
        if ($url !== null)
        {
            $this->setUrl($url);
        }
    }

    public function setUrl(string $url): WebClient
    {
        $this->pub_curl_option[CURLOPT_URL] = $url;

        return $this;
    }


    public function setTimeout(float $timeout): WebClient
    {
        $this->pub_curl_option[CURLOPT_TIMEOUT] = $timeout;

        return $this;
    }

    public function setConnectTimeout(float $connectTimeout): WebClient
    {
        $this->pub_curl_option[CURLOPT_CONNECTTIMEOUT] = $connectTimeout;
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
            $this->pub_curl_option = $opt + $this->pub_curl_option;
        }
        else
        {
            $this->pub_curl_option = $opt;
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
        $this->pub_is_post = true;
        $this->pub_post_data = $data;


        $response = $this->exec();

        return $response;
    }

    public function postForm(array $data)
    {
        $this->pub_is_post = true;
        $this->pub_post_data = $data;

        $this->setHeader('Content-Type', 'application/x-www-form-urlencoded');

        $response = $this->exec();

        return $response;
    }

    public function get()
    {
        $this->pub_is_post = false;

        $response = $this->exec();


        return $response;
    }

    private function exec(): Response
    {
        $curl = curl_init();

//        var_dump($this->getOption());
        curl_setopt_array($curl, $this->getOption());

        $result = curl_exec($curl);

        return new Response($result, $curl);
    }


    private function getOption(): array
    {
        $option = $this->pub_curl_option;

        if (isset($this->pub_post_data))
        {
            //参数
            if ($this->pub_is_post)
            {
                //若请求为POST类型，则$option中的优先级最高
                $option[CURLOPT_POST] = true;

                if (is_array($this->pub_post_data))
                {
                    $option[CURLOPT_POSTFIELDS] = http_build_query($this->pub_post_data);
                }
                else
                {
                    $option[CURLOPT_POSTFIELDS] = $this->pub_post_data;
                }
            }

//            var_dump($option[CURLOPT_POSTFIELDS]);
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
                $arr[] = $key . ':' . $val;
            }


            $option[CURLOPT_HTTPHEADER] = $arr;
        }

        return $option;
    }
}