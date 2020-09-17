<?php

namespace XWX\Common\Redis;


use XWX\Common\H;

/**
 * Redis锁逻辑
 */
class RedisLock
{
    public function __construct($redis)
    {
        if (isset($redis))
        {
            $this->setRedis($redis);
        }
    }


    private $pub_redis;

    /**
     * 设置redis
     * @param $redis
     * @return $this
     */
    function setRedis($redis)
    {
        $this->pub_redis = $redis;
        return $this;
    }

    /**
     * @return \Redis
     */
    function getRedis()
    {
        return $this->pub_redis;
    }


    /**
     * 加锁
     *
     * 成功则返回锁匙，用于解锁
     * @param $key
     * @param int $lock_s
     * @return string|null
     * @throws \Exception
     */
    function lock($key, $lock_s = 5)
    {
        $redis = $this->getRedis();
        $lock_key = "RedisLock:{$key}";

        $lock_token = H::funcGetID();

        $lock = $redis->rawCommand('set', $lock_key, $lock_token, 'ex', $lock_s, 'nx');
        if ($lock == null)
        {
            //加锁失败
            return null;
        }

        return $lock_token;
    }


    /**
     * 解锁
     * @param $key
     * @param null $lock_token
     */
    function unLock($key, $lock_token = null)
    {
        $redis = $this->getRedis();
        $lock_key = "RedisLock:{$key}";

        $do_del = false;
        if (H::funcStrHasAnyText($lock_token))
        {
            //存在钥匙判断是否正确，正确则可删除
            $val = $redis->get($lock_key);
            if ($val == $lock_token)
            {
                $do_del = true;
            }
        }
        else
        {
            $do_del = true;
        }

        if ($do_del)
        {
            $redis->del($lock_key);
        }
    }


    function func($func, $key, $lock_s = 5)
    {
        $lock_token = null; //钥匙

        $sleep_s = 0.02; //每次等待200毫秒

        //尝试加锁
        $try_s_total = $lock_s; //尝试总数
        $try_s = 0;
        while (true)
        {
            if ($try_s > $try_s_total)
            {
                throw new \Exception('RedisLock timeout');
            }


            $lock_token = $this->lock($key, $lock_s);
            if (H::funcStrHasAnyText($lock_token))
            {
                break;
            }

            \Swoole\Coroutine::sleep($sleep_s);
            $try_s += $sleep_s;
        }


        try
        {
            $res = $func();
            return $res;
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        finally
        {
            //解锁
            $this->unLock($key, $lock_token);
        }
    }
}