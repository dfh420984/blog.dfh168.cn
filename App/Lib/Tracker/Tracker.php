<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/10/27
 * Time: 8:48 PM
 */
namespace App\Lib\Tracker;
use EasySwoole\Component\Singleton;

class Tracker extends \EasySwoole\Trace\Bean\Tracker
{
    use Singleton;
}