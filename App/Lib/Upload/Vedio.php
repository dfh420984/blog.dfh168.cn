<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/19
 * Time: 22:00
 */
namespace App\Lib\Upload;


class Vedio extends Base {

    public $fileType = 'video';
    public $maxSize = '';
    public $fileExtTypes = [
        'mp4',
        'x-flv'
    ];
}
