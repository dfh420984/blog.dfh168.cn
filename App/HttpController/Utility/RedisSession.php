<?php

namespace App\HttpController\Utility;

use EasySwoole\EasySwoole\Config;
use EasySwoole\Http\Session\SessionHandler;
use EasySwoole\Component\Singleton;
use Redis;

class RedisSession extends SessionHandler implements \SessionHandlerInterface
{
    use Singleton;

    private $options = [
        'handler' => null,
        'host' => null,
        'port' => null,
        'lifetime' => null,
        'prefix' => '',
    ];

    /**
     * @return bool
     */
    public function close()
    {
        return $this->options['handler']->close();
        // TODO: Implement close() method.
    }

    /**
     * @param string $session_id
     * @return bool
     */
    public function destroy($session_id): bool
    {
        $session_id = $this->options['prefix'] . $session_id;
        return $this->options['handler']->delete($session_id) >= 1 ? true : false;
    }

    /**
     * @param int $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime): bool
    {
        // TODO: Implement gc() method.
        return true;
    }

    /**
     * @param $save_path
     * @param $name
     * @return bool
     */
    public function open($save_path, $name): bool
    {
        $conf = Config::getInstance()->getConf('redis'); //配置文件需要自行设置好加载和调用
        $this->options['host'] = $conf['host'];
        $this->options['port'] = $conf['port'];
        $this->options['prefix'] = $name . '_';
        $set = Config::getInstance()->getConf('session');
        if (!empty($set)) {
            $maxLifeTime = $set['lifetime'];
        } else {
            $maxLifeTime = 3600 * 24 * 30;
        }
        $this->options['lifeTime'] = $maxLifeTime;
        if (is_resource($this->options['handler'])) return true;
        //连接redis
        $redisHandle = new Redis();
        $redisHandle->connect($this->options['host'], $this->options['port']);
        if (!$redisHandle) {
            return false;
        }
        $this->options['handler'] = $redisHandle;
        return true;
    }

    /**
     * @param string $session_id
     * @return string
     */
    public function read($session_id)
    {
        $session_id = $this->options['prefix'] . $session_id;
        $data = $this->options['handler']->get($session_id);
        for($i=0;$i<3;$i++) {
            if ($data == "+OK") {
                $data = $this->options['handler']->get($session_id);
            } else {
                break;
            }
        }
        return $data;
    }

    /**
     * @param string $session_id
     * @param string $session_data
     * @return bool
     */
    public function write($session_id, $session_data)
    {
        $session_id = $this->options['prefix'] . $session_id;
        if (!empty($session_data) && !empty(unserialize($session_data))) {
            return $this->options['handler']->setex($session_id, $this->options['lifeTime'], $session_data);
        }
    }
}