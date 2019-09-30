<?php

namespace XWX\Common\Traits;


use XWX\Common\XReturn;

trait TraitCommon
{
    /**
     * @param $errcode
     * @param $errmsg
     * @param array $data
     * @return XReturn
     */
    function funcGetR($errcode, $errmsg = '', $data = [])
    {
        $r = new XReturn();
        $r->errcode = $errcode;
        $r->errmsg = $errmsg;
        $r->setVal('return_data', $data);

        return $r;
    }
}