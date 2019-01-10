<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/8/15
 * Time: 上午12:02
 */
namespace App\Lib\Tracker;
use EasySwoole\Component\Singleton;
class TrackerManager extends \EasySwoole\Trace\TrackerManager
{
    use Singleton;
}