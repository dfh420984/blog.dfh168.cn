<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/19
 * Time: 22:01
 */

namespace App\Lib\Upload;

use EasySwoole\Http\Request;

class Base
{
    public $data = ['code' => 0, 'msg' => 'ok', 'data' => []];
    public $rootPath = '/uploads';
    private $request = null;
    public $size = 0;
    public $fileName = '';
    public $extension = '';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**多图上传**/
    public function uploads()
    {
        try {
            $fileUploadObjs = $this->request->getUploadedFiles(); //获取多个上传对象
            foreach ($fileUploadObjs as $key => $val) {
                if(is_array($fileUploadObjs[$key])) {
                    foreach ($fileUploadObjs[$key] as $key2=>$fileObj) { //同一名称上传多个图片时
                        $this->doUpload($fileObj, $key, $key2);
                    }
                } else {
                    $fileObj = $fileUploadObjs[$key];
                    $key2 = 0;
                    $this->doUpload($fileObj, $key, $key2);
                }
        }
            return $this->data;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function doUpload($fileObj, $key=0, $key2=0) {
        if ($this->getError($fileObj)) {
            $this->size = $fileObj->getSize();
            if ($this->checkSize()) {
                $this->fileName = $fileObj->getClientFilename();
                if ($this->checkFileExtType()) {
                    $targetPath = $this->getTargetPath();
                    if ($fileObj->moveTo($targetPath)) {
                        if (empty($key) && empty($key2)) {
                            $this->data['data'] = $targetPath;  //单文件返回
                        }else {
                            $this->data['data'][$key][$key2] = $targetPath;   //处理多文件返回
                        }
                    } else {
                        $this->data['code'] = 1;
                        $this->data['msg'] = '上传文件失败';
                    }
                }
            }
        }
    }

    /**单文件上传**/
    public function upload() {
        try {
            $fileUploadObjs = $this->request->getUploadedFiles(); //获取单个上传对象
            foreach ($fileUploadObjs as $key => $fileObj) {
                $this->doUpload($fileObj);
            }
            return $this->data;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    public function getError($fileObj)
    {
        if (!empty($fileObj->getError())) {
            $this->data['code'] = $fileObj->getError();
            $this->data['msg'] = '上传文件错误';
            return false;
        }
        return true;
    }

    public function checkFileExtType()
    {
        if (empty($this->fileName)) {
            $this->data['code'] = 1;
            $this->data['msg'] = '获取pathinfo错误';
            return false;
        } else {
            $pathinfo = pathinfo($this->fileName);
            $this->extension = strtolower($pathinfo['extension']);
            if (!in_array($this->extension, $this->fileExtTypes)) {
                $this->data['code'] = 1;
                $this->data['msg'] = '上传文件类型不正确,支持格式为:' . implode(',', $this->fileExtTypes);
            }
        }
        return true;
    }

    public function checkSize()
    {
        if (empty($this->size)) {
            $this->data['code'] = 1;
            $this->data['msg'] = '尺寸不能为空';
            return false;
        } else {
            if ($this->size > $this->maxSize) {
                $this->data['code'] = 1;
                $this->data['msg'] = '尺寸过大,最大尺寸为:' . (round($this->maxSize / (1024 * 1024))) . 'M';
                return false;
            }
        }
        return true;
    }

    public function getTargetPath()
    {
        $nameClass = strtolower(str_replace('\\', '/', get_class($this))); //get_class获取的是带命名空间类名
        $nameClassArr = explode('/', $nameClass);
        $dirName = array_pop($nameClassArr);
        $uploadPath = '/' . $dirName . '/' . date("Y") . '/' . date("m") . '/';
        $fileName = md5(uniqid(rand())) . '.' . $this->extension;
        $fullPath = $this->rootPath . $uploadPath;
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
        $fullPath .= $fileName;
        return $fullPath;
    }
}