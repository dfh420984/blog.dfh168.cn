<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/19
 * Time: 22:00
 */
namespace App\Lib\Upload;


class Vedio extends Base {

    public $maxSize = '1024*1024';
    public $fileExtTypes = [
        'mp4',
        'x-flv'
    ];
}
