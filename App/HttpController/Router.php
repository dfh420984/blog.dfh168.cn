<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/8/15
 * Time: 上午10:39
 * 自定义路由
 */

namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\AbstractRouter;
use FastRoute\RouteCollector;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;

class Router extends AbstractRouter
{
    function initialize(RouteCollector $routeCollector)
    {
        // TODO: Implement initialize() method.
//        $routeCollector->get('/user','/index.html');
//        $routeCollector->get('/test','/Index/test');
//        $routeCollector->get('/rpc','/Rpc/index');
//
//        $routeCollector->get('/',function (Request $request ,Response $response){
//            $response->write('this router index');
//        });
        // /test/index.html
        $routeCollector->get('/test',function (Request $request ,Response $response){
            $response->write('this router test');
            $response->end();
        });
        // /user/1/index.html
//        $routeCollector->get( '/user/{id:\d+}',function (Request $request ,Response $response,$id){
//            $response->write("this is router user ,your id is {$id}");
//            $response->end();
//        });

    }
}