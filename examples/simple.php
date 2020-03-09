<?php
/**
 * Created by PhpStorm.
 * User: 黄云建
 * Date: 2020/02/19
 * Time: 11:30
 */

//redis服务对应本机端口映射  由于redis服务器不支持本机连接故使用端口映射到本机解决 仅供测试使用
$ips = [
    '10.64.81.142'=>['ip'=>'127.0.0.1','port'=>'7142','wlan'=>'101.36.149.73'],
    '10.64.82.167'=>['ip'=>'127.0.0.1','port'=>'7167','wlan'=>'101.36.149.41'],
    '10.64.81.108'=>['ip'=>'101.36.149.189','port'=>'7979','wlan'=>'101.36.149.189']
    ];
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

function redis_nodeinfo(){
    $random = [];
    $ips = [];


    //哨兵节点
    $temp_data = [['ip'=>'101.36.149.73','port'=>263719],['ip'=>'101.36.149.41','port'=>26379],['ip'=>'101.36.149.189','port'=>26379]];
    for($count=1;$count<count($temp_data);$count++){
        $random[] =$count;
    }
    shuffle($random);
    foreach($random as $key){
        $ips[$temp_data[$key]['ip']]=['port'=>$temp_data[$key]['port']];
    }
    $sentinel = new \huangyunjian\RedisSentinel\Sentinel();
    foreach($ips as $ip=>$portinfo){
        try{
            $sentinel->connect($ip, $portinfo['port'],1);
            $address = $sentinel->getMasterAddrByName('myredis');
            if($address){
                echo '哨兵节点:' .$ip .'正常'. '<br/>';

                return $address;
            }
        }catch(Exception $e){
            echo '哨兵节点:' .$ip .'异常 异常信息:' . $e->getMessage() . '<br/>';
        }
    }




}

$address = redis_nodeinfo();
echo 'redis_ip:' . $address['ip'] . '<br/>';
//$sentinel = new \huangyunjian\RedisSentinel\Sentinel();
//$sentinel->connect('101.36.149.189', 26379,1);
//$address = $sentinel->getMasterAddrByName('myredis');
//echo $address['ip'];
$redis = new Redis();
$redis->connect($ips[$address['ip']]['ip'],$ips[$address['ip']]['port']);
$redis->auth('QWgjfu2T31oddaZP');
$info = $redis->info();
print_r($info);