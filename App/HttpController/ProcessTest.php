<?php
/**
 * Created by PhpStorm.
 * User: Apple
 * Date: 2018/11/1 0001
 * Time: 11:30
 */
namespace App\HttpController;
use EasySwoole\Http\AbstractInterface\Controller;
class ProcessTest extends Controller
{
    public function index()
    {
        // TODO: Implement index() method.
        $this->response()->write('ok');
    }

    public function run()
    {
        echo "process is run.\n";
        // TODO: Implement run() method.
    }
    public function onShutDown()
    {
        echo "process is onShutDown.\n";
        // TODO: Implement onShutDown() method.
    }
    public function onReceive(string $str)
    {
        echo "process is onReceive.\n";
        // TODO: Implement onReceive() method.
    }
}