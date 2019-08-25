<?php

namespace Tests;


use XWX\Common\H;
use XWX\Common\WebClient\WebClient;
use XWX\Common\XReturn;

class test_base extends TestBase
{
    function test_trueOrFalse()
    {
        $this->funcLog('=======true or false======');
        $this->funcLog('空字符串：' . ('' ? 'true' : 'false'));
        $this->funcLog('空数组:' . ([] ? 'true' : 'false'));
        $this->funcLog('数字0的字符串:' . ('0' ? 'true' : 'false'));
        $this->funcLog('数字0:' . (0 ? 'true' : 'false'));

        $this->funcLog('=======null======');
        $this->funcLog('空字符串 == null：' . ('' == null ? 'true' : 'false'));
        $this->funcLog('空字符串 === null：' . ('' === null ? 'true' : 'false'));
        $this->funcLog('空数组 == null：' . ([] == null ? 'true' : 'false'));
        $this->funcLog('数字0的字符串 == null：' . ('0' == null ? 'true' : 'false'));
        $this->funcLog('数字0 == null：' . (0 == null ? 'true' : 'false'));

        $this->funcLog('======is_null=======');
        $this->funcLog('空字符串：' . (is_null('') ? 'true' : 'false'));
        $this->funcLog('空数组：' . (is_null([]) == null ? 'true' : 'false'));
        $this->funcLog('数字0的字符串：' . (is_null('0') == null ? 'true' : 'false'));
        $this->funcLog('数字0：' . (is_null(0) == null ? 'true' : 'false'));

        $this->assertTrue(true);
    }

    function test_isWin()
    {
        $this->assertTrue($this->H()->funcIsWin());
    }

    function test_xreturn()
    {
        $r = new XReturn();
        $r->errmsg = '123';
        $r->setData('xx', [123]);

//        var_dump($r);
        print json_encode($r);
    }

    function test_wxcard()
    {
        $access_token = '24_nRlIDFwG6-tD_0VQ8aMS_EDjAGJ5zxMlsuEi5pI3n0xRcBcRWwpaAK7N9n6G-x__P3tEilPevCA_BWjW_jNDseytrrZr6J21eeA794Th-Js9G12Hw1wEK4BElceg4omttTPlTRtru3mFSJTPHINdCDARSX';
        $url = 'https://api.weixin.qq.com/card/update?access_token=' . $access_token;
        $client = new WebClient($url);

        $member_card = [
            'modify_msg_operation' => [
                'url_cell' => [
                    'card_id_list' => [
                        'p_OyEjpMq3_ah8dPNUtyXmMEqofs'
                    ],
                    'end_time' => H::today()->addMonths(10)->timestamp,
                    'text' => '测试，积分余额变动',
                    'url' => 'www.qq.com',
                ]
            ]
        ];

        $post_data = [
            'card_id' => 'p_OyEjiIi6i1oE3dSIQKCK3ycXN8',
            'member_card' => $member_card
        ];

        $string1 = json_encode($post_data, JSON_UNESCAPED_UNICODE);
        var_dump($string1);

        $res = $client->post($string1);
        $return_string = $res->getBody();

        var_dump($return_string);
    }


    function test_mongodb()
    {
//        var_dump(extension_loaded("mongodb"));

//        var_dump(get_extension_funcs('mongodb'));
        $manager = new \MongoDB\Driver\Manager("mongodb://192.168.2.88:27017");

        //db.getCollectionNames();
        $cmd_arr = [
            'listCollections' => 1,
            'authorizedCollections ' => true,
            'nameOnly' => true,
        ];

        //db.t_test.getIndexes();
        $cmd_arr = [
            'listIndexes' => 't_test',
        ];
        $cmd = new \MongoDB\Driver\Command($cmd_arr);
        $row = $manager->executeCommand('test', $cmd);
//
        var_dump($row->toArray());
    }
}