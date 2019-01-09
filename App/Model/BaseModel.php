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
use EasySwoole\Spl\SplBean;

class BaseModel extends SplBean
{

    /**获得mysql连接池链接**/
    public function getMysqlPoolObj()
    {
        $db = PoolManager::getInstance()->getPool(MysqlPool::class)->getObj(Config::getInstance()->getConf('mysql.pool_time_out'));
        return $db;
    }

    /**释放mysql连接池链接**/
    public function recycleMysqlPoolObj($db)
    {
        PoolManager::getInstance()->getPool(MysqlPool::class)->recycleObj($db);
    }

    /**
     * 通过反射给类属性从新赋值
     * @param $obj Object 类实例对象
     * @param $data Array 传值数组
     */
    public function getRelectObj($obj, $data)
    {
        $reflectObject = new  \ReflectionObject($obj);
        $methods = $reflectObject->getMethods();
        foreach ($methods as $key => $method) {
            if (count($params = $method->getParameters()) > 0) {
                $paramName = $params[0]->getName();
                if (isset($data[$paramName])) {
                    $method->invoke($obj, $data[$paramName]);
                }
            }
        }
        return $obj;
    }

    public function returnData($code = 0, $msg = 'ok', $data = '')
    {
        return  ['code' => $code, 'msg' => $msg, 'data' => $data];
    }

}