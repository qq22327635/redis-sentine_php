

redis-sentinel client for php based on phpredis extension.

## examples
Get Redis master address and create Redis object:
```php
$sentinel = new \Jenner\RedisSentinel\Sentinel();
$sentinel->connect('127.0.0.1', 263719);
$address = $sentinel->getMasterAddrByName('myredis');

$redis = new Redis();
$redis->connect($address['ip'], $address['port']);
$info = $redis->info();
print_r($info);
```
