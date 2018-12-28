<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Component\Di;
use App\Lib\Redis\Redis;
use EasySwoole\Utility\File;
use App\Lib\Process\Consumer;
use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\Component\Pool\PoolManager;
use App\Lib\Process\HotReload;
use App\Lib\Pool\MysqlPool;

class EasySwooleEvent implements Event
{


    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
        self::loadConf();
    }

    /**
     * 加载配置文件
     */
    public static function loadConf($appPath = '/App/Config')
    {
        $files = File::scanDirectory(EASYSWOOLE_ROOT . $appPath);
        if (is_array($files)) {
            foreach ($files['files'] as $file) {
                //$file = strtolower($file); (此处转小写可能会有问题)
                $fileNameArr = explode('.', $file);
                $fileSuffix = end($fileNameArr);
                if ($fileSuffix == 'php') {
                    Config::getInstance()->loadFile($file);
                } elseif ($fileSuffix == 'env') {
                    Config::getInstance()->loadEnv($file);
                }
            }
        }
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        //注入redis单例
        Di::getInstance()->set('REDIS', Redis::getInstance());

        // 注册mysql数据库连接池
        PoolManager::getInstance()->register(MysqlPool::class, Config::getInstance()->getConf('mysql.pool_max_num'));
        //注册热重载
        $swooleServer = ServerManager::getInstance()->getSwooleServer();
        $swooleServer->addProcess((new HotReload('HotReload', ['disableInotify' => false]))->getProcess());

        //self::Consumer()

    }

    public static function Consumer() {
        //注册自定义消费进程
        $allNum = 3;
        for ($i = 0; $i < $allNum; $i++) {
            ServerManager::getInstance()->getSwooleServer()->addProcess((new Consumer("consumer_{$i}"))->getProcess());
        }
    }


    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }

    public static function onReceive(\swoole_server $server, int $fd, int $reactor_id, string $data):void
    {

    }

}