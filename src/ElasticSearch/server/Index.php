<?php

namespace XWX\Common\ElasticSearch\server;


use XWX\Common\HttpMethod;

class Index extends ServerBase
{
    function get($index)
    {
        $url = $this->funcGetUrl($index);

        $r = $this->funcRetrun(HttpMethod::GET, $url);

        return $r;
    }


    function delete($index)
    {
        $url = $this->funcGetUrl($index);

        $r = $this->funcRetrun(HttpMethod::DELETE, $url);

        return $r;
    }
}