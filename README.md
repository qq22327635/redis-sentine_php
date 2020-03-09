redis-sentinel client for php based on phpredis extension.

examples
获取哨兵节点master ip和端口 和连接redis服务器


$sentinel = new \Jenner\RedisSentinel\Sentinel();
$sentinel->connect('127.0.0.1', 263719);
$address = $sentinel->getMasterAddrByName('myredis');

$redis = new Redis();
$redis->connect($address['ip'], $address['port']);
$info = $redis->info();
print_r($info);


##php examples 文件参考 vendor/huangyunjian/redis-sentine_php/examples/simple.php

复制文件到 vendor/huangyunjian/redis-sentine_php/examples/simple.php 文件到站点目录 然后运行看看