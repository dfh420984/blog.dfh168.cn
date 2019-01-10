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
use EasySwoole\Component\Context;

class BaseModel extends SplBean
{

    /**
     * ContextManager上下文管理器
    *  在swoole中,由于多个协程是并发执行的，因此不能使用类静态变量/全局变量保存协程上下文内容。使用局部变量是安全的，因为局部变量的值会自动保存在协程栈中，其他协程访问不到协程的局部变量。
    *  在控制器中,我们可以使用ContextManager保存协程上下文内容
     * 在 onRequest全局事件中注册MysqlObject
     **/
    public function getMysqlPoolObj()
    {
        $db = PoolManager::getInstance()->getPool(MysqlPool::class)->getObj(Config::getInstance()->getConf('mysql.pool_time_out'));//获得mysql连接池链接
        //注册一个mysql连接,这次请求都将是单例Mysql的
        //在控制器中获取本次请求唯一的一个数据库连接
        Context::getInstance()->set('mysqlObject',$db);
        $mysqlObject = Context::getInstance()->get('mysqlObject');
        return $mysqlObject;
    }

    /**释放mysql连接池链接**/
    public function recycleMysqlPoolObj($mysqlObject)
    {
        PoolManager::getInstance()->getPool(MysqlPool::class)->recycleObj($mysqlObject);
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
        $className = $reflectObject->getName(); //获取类名
        foreach ($methods as $key => $method) {
            if ($method->getDeclaringClass()->getName() == $className && preg_match('/^set|get\.*/',$method->getName())) {
                if (count($params = $method->getParameters()) > 0) {
                    $paramName = $params[0]->getName();
                    if (isset($data[$paramName])) {
                        $method->invoke($obj, $data[$paramName]);
                    }
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