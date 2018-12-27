<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/19
 * Time: 22:00
 */
namespace App\Lib\Upload;


class Image extends Base {

    public $maxSize = 1024 * 1024;
    public $fileExtTypes = [
        'png',
        'jpg',
        'jpeg',
        'gif'
    ];
}
