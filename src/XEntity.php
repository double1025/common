<?php

namespace XWX\Common;


use XWX\Common\Traits\TraitCommon;

class XEntity implements \JsonSerializable
{
    use TraitCommon;


    const FILTER_NOT_NULL = 1;

    private $pub_keys;


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
            $new_data = array_filter($data, $filter);
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

            $this->setVal($k, $v);
        }
    }


    /**
     * 赋值
     *
     * @param $key
     * @param null $value
     */
    final public function setVal($key, $value = null): void
    {
        if ($this->keyExists($key))
        {
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


    final public function jsonSerialize()
    {
        $data = [];
        foreach ($this as $key => $item)
        {
            if ($key == 'pub_keys')
            {
                continue;
            }

            $data[$key] = $item;
        }

        return $data;
    }
}