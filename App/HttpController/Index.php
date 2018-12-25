<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/12
 * Time: 16:35
 */
namespace App\HttpController;

use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\Http\AbstractInterface\Controller;

class Index extends Base
{

        function index()
        {
            // Blade View
           // $this->render('index');     # 对应模板: Views/index.blade.php
           $this->response()->redirect("/admin/index.html");
        }
//    function index()
//    {
//        $ip = ServerManager::getInstance()->getSwooleServer()->connection_info($this->request()->getSwooleRequest()->fd);
////        var_dump($ip);
//        $this->response()->write('your ip:'.$ip['remote_ip']);
//        $this->response()->write('Index Controller is run');
//        // TODO: Implement index() method.
//    }
//
//    function test()
//    {
//        $this->response()->write('hello haha');
//    }
}
