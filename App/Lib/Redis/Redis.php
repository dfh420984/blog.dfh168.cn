<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/16
 * Time: 21:47
 */

namespace App\Lib\Redis;

use EasySwoole\Component\Singleton;
use EasySwoole\EasySwoole\Config;

class Redis
{
    use Singleton;
    public $redis = null;

    private function __construct()
    {
        try {
            if (!extension_loaded('redis')) {
                throw new \Exception('redis.so扩展不存在');
            }
            $this->redis = new \Redis();
            $redisConf = Config::getInstance()->getConf('redis');
            $res = $this->redis->connect($redisConf['host'], $redisConf['port'], $redisConf['timeout']);
        } catch (\Exception $e) {
            throw new \Exception('redis服务异常');
        }
        if ($res === false) {
            throw new \Exception('redis链接服务异常');
        }
    }

    /**
     * 获取指定key值
     * @param $key
     * @return bool|string
     */
    public function get($key)
    {
        if (empty($key)) {
            return '';
        }
        return $this->redis->get($key);
    }

    /**
     * @param $list
     * redis队列入队
     */
    public function rpush($list, $val)
    {
        if (empty($list)) {
            return '';
        }
        return $this->redis->rpush($list, $val);
    }

    /**
     * @param $list
     * @return string
     * redis出队
     */
    public function lpop($list)
    {
        if (empty($list)) {
            return '';
        }
        return $this->redis->lpop($list);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        if (empty($arguments)) {
            return '';
        }
        return $this->redis->$name($arguments[0]);
    }
}