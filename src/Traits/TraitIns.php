<?php

namespace XWX\Common\Traits;


trait TraitIns
{
    private static $pub_instance;

    /**
     * 只会new一次
     *
     * @param mixed ...$args
     * @return static
     */
    static function funcInsStatic(...$args)
    {
        if (!isset(self::$pub_instance))
        {
            self::$pub_instance = new static(...$args);
        }

        return self::$pub_instance;
    }

    /**
     * 每次调用都new
     *
     * @param mixed ...$args
     * @return static
     */
    static function funcIns(...$args)
    {
        return new static(...$args);
    }
}