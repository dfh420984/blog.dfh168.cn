<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/12
 * Time: 16:35
 */
namespace App\HttpController;

use EasySwoole\Component\Di;

class Index extends Base
{
    public function index()
    {
        // TODO: Implement index() method.
    }

    public function video()
    {
        $data = $this->getDB();
        return $this->response()->write(json_encode($data));
    }

    /**
     * 测试数据库
     * @return \EasySwoole\Mysqli\Mysqli|mixed
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    public function getDB()
    {
        //$conf = new \EasySwoole\Mysqli\Config(\EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL'));
        $conf = new \EasySwoole\Mysqli\Config(\EasySwoole\EasySwoole\Config::getInstance()->getConf('database'));
        $db = new \EasySwoole\Mysqli\Mysqli($conf);
        $data = $db->get('live_player');//获取一个表的数据
        return $this->response()->write(json_encode($data));
    }

    /**
     * @return bool
     * @throws \Throwable
     * 测试获取key
     */
    public function getRedis()
    {
        try {
            $res = Di::getInstance()->get('REDIS')->get('test');
            return $this->response()->write($res);
        } catch (\Exception $e) {
            return $this->response()->write($e->getMessage());
        }
    }

    /**
     * @return bool
     * @throws \Throwable
     * 入队
     */
    public function rpush()
    {
        try {
            $list = 'testlist';
            $val = $this->request()->getRequestParam('a');
            $data = Di::getInstance()->get('REDIS')->rpush($list, $val);
            return $this->writeJson(200, 'ok', $data);
        } catch (\Exception $e) {
            return $this->response()->write($e->getMessage());
        }
    }

    /**
     * @return bool
     * @throws \Throwable
     * 出队
     */
    public function lpop()
    {
        try {
            $list = 'testlist';
            $data = Di::getInstance()->get('REDIS')->lpop($list);
            return $this->writeJson(200, 'ok', $data);
        } catch (\Exception $e) {
            return $this->response()->write($e->getMessage());
        }
    }
}
