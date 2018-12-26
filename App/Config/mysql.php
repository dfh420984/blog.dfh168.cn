<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/16
 * Time: 23:19
 */
################ DATABASE CONFIG ##################
//mysql连接池配置
return [
    'host'=>'mysql',
    'port'=>3306,
    'user'=>'root',
    'password'=>'DockerLNMP',
    'database'=>'blog',
    'charset' => 'utf8',
    'timeout' => 5,
    'pool_max_num' => 20,
    'pool_time_out' => 1
];