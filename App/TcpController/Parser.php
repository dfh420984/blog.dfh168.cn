<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/14
 * Time: 11:37
 */
namespace App\TcpController;
use EasySwoole\Socket\AbstractInterface\ParserInterface;
use EasySwoole\Socket\Bean\Caller;
use EasySwoole\Socket\Bean\Response;
class Parser implements ParserInterface {

    public function decode($raw, $client):?Caller {

    }

    public function encode(Response $response, $client):?string {

    }
}