# common
## 介绍
帮忙插件，让开发更便捷
- 数据验证组件-Validate
- 数组处理组件-XArray
- URL请求组件-WebClient
- 常用方法

## Validate
```
$v = new Validate();
$v->addColumn('t1')
    ->required()
    ->lenBetween(0, 10)
    ->url();
$v->addColumn('t2')
    ->required()
    ->lenBetween(0, 10)
    ->url();

$r = $v->validate([
    't1' => '',
    't2' => 'http://baidu.com',
], true);
```

## XArray
```
$xarr = XArray::funcIns($arr);
$this->funcCollect();

$r = $xarr->where('a', 1, '>')
    ->where('b', 1.1, '>')
    ->where('c', 1.1, '>')
    ->order('b', SORT_DESC)
    ->select(['a', 'd'])
    ->get();
```