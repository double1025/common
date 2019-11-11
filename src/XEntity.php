<?php

namespace XWX\Common;


use Carbon\Carbon;
use XWX\Common\Traits\TraitCommon;

class XEntity implements \JsonSerializable
{
    use TraitCommon;


    const FILTER_NOT_NULL = 1;

    //所有字段名
    private $pub_keys;
    //设置过值的字段名
    public $pub_keys__set = [];


    public function __construct($data = null)
    {
        if ($data != null)
        {
            $this->fill($data);
        }
    }


    /**
     * 返因数组
     *
     * @param null $filter
     * @return array
     */
    public function toArray($filter = null)
    {
        $data = $this->jsonSerialize();
        $new_data = [];
        if (is_callable($filter))
        {
            //匿名函数
            $new_data = array_filter($data, $filter, 1);//1表示,functino($v,$k)
        }
        else if ($filter == self::FILTER_NOT_NULL)
        {
            //不等于null
            $new_data = array_filter($data, function ($val)
            {
                return !is_null($val);
            });
        }
        else
        {
            $new_data = $data;
        }


        return $new_data;
    }


    /**
     * 填充
     *
     * @param array $data
     */
    public function fill(array $data)
    {
        foreach ($data as $k => $v)
        {
            if (!$this->keyExists($k))
            {
                continue;
            }

            //初始化不记录，字段赋值
            $this->setVal($k, $v, false);
        }
    }


    /**
     * 赋值
     *
     * @param $key
     * @param null $value
     * @param bool $do_set_keys true:记录字段赋值;
     */
    final public function setVal($key, $value = null, $do_set_keys = true): void
    {
        if ($this->keyExists($key))
        {
            if ($do_set_keys)
            {
                //新值与旧值，不一致，记录，已修改过
                if ($this->$key != $value)
                {
                    $this->pub_keys__set[$key] = 1;
                }
            }

            $this->$key = $value;
        }
    }

    /**
     * 获取字段值
     *
     * @param $key
     * @return null
     */
    final public function getVal($key)
    {
        if ($this->keyExists($key))
        {
            return $this->$key;
        }
        else
        {
            return null;
        }
    }


    /**
     * 字段名是否存在
     * @param $key
     * @return bool
     */
    final public function keyExists($key)
    {
        return in_array($key, $this->keys());
    }


    /**
     * 获取所有字段名
     *
     * @return array
     */
    final public function keys()
    {
        if (!isset($this->pub_keys))
        {
            $data = $this->jsonSerialize();
            $this->pub_keys = array_keys($data);
        }

        return $this->pub_keys;
    }


    /**
     * 获取已赋值过的字段名
     *
     * @return array
     */
    final public function keysSet()
    {
        return array_keys($this->pub_keys__set);
    }


    final public function jsonSerialize()
    {
        $data = [];
        foreach ($this as $key => $item)
        {
            if (in_array($key, ['pub_keys', 'pub_keys__set']))
            {
                continue;
            }

            $val = $item;
            if (is_a($item, Carbon::class))
            {
                //Carbon输出string
                $val = $item->toDateTimeString();
            }

            $data[$key] = $val;
        }

        return $data;
    }


    //获取字段是否被赋值
    public function __set($name, $value)
    {
        $this->setVal($name, $value);
    }

    public function __get($name)
    {
        return $this->getVal($name);
    }
}