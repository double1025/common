# common
## 安装
```
composer require xwx/common
```
## 介绍
帮忙插件，让开发更便捷
- 数据验证组件-Validate
- 数组处理组件-XArray
- URL请求组件-WebClient
- 生成验证-VCode
- 常用方法

## Validate
```php
$v = new Validate();
//添加验证条件
$v->addColumn('t1')
    ->required()
    ->lenBetween(0, 10)
    ->url();
$v->addColumn('t2')
    ->required()
    ->lenBetween(0, 10)
    ->url();
//进行参数验证
$r = $v->validate([
    't1' => '',
    't2' => 'http://baidu.com',
], true);
```

## XArray
```php
$xarr = XArray::funcIns($arr);
//链式数组处理
$r = $xarr->where('a', 1, '>')
    ->where('b', 1.1, '>')
    ->where('c', 1.1, '>')
    ->order('b', SORT_DESC)
    ->select(['a', 'd'])
    ->get();
```

## WebClient
```php
$url = 'https://www.baidu.com';
$client = new WebClient($url);
$res = $client->get()
$return_string = $res->getBody();
```

## VCode
```php
$v = new \XWX\Common\XImage\VCode();
//保存图片到磁盘
//$v->funcCodeSave(rand(1000, 9999), 'D:/1.jpg');
//直接输入png图片
$v->funcCodeToPng(rand(1000, 9999)); 
```