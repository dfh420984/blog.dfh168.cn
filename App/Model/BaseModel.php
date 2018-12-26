<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/25
 * Time: 18:02
 */
namespace App\Model;

use EasySwoole\EasySwoole\Config;
use App\Lib\Pool\MysqlPool;
use EasySwoole\Component\Pool\PoolManager;

class BaseModel {

    /**获得mysql连接池链接**/
    public function getMysqlPoolObj() {
        $db = PoolManager::getInstance()->getPool(MysqlPool::class)->getObj(Config::getInstance()->getConf('mysql.pool_time_out'));
        return $db;
    }

    /**释放mysql连接池链接**/
    public function recycleMysqlPoolObj($db) {
        PoolManager::getInstance()->getPool(MysqlPool::class)->recycleObj($db);
    }

}