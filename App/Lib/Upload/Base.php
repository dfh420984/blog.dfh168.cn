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

    public $type = ''; //上传的文件名称
    public $data = ['code' => 0, 'msg' => '', 'data' => ''];
    public $rootPath = EASYSWOOLE_ROOT . '/Public/uploads';
    private $request = null;
    public $size = 0;
    public $fileName = '';
    public $extension = '';

    public function __construct(Request $request)
    {
        $this->request = $request;
        $files = $this->request->getSwooleRequest()->files;
        $types = array_keys($files);
        $this->type = $types[0];
    }

    public function upload()
    {
        try {
            $fileObj = $this->request->getUploadedFile($this->type);
            if ($this->getError($fileObj)) {
                $this->size = $fileObj->getSize();
                if ($this->checkSize()) {
                    $this->fileName = $fileObj->getClientFilename();
                    if ($this->checkFileExtType()) {
                        $targetPath = $this->getTargetPath();
                        if ($fileObj->moveTo($targetPath)) {
                            $this->data['data'] = $targetPath;
                        } else {
                            $this->data['code'] = 1;
                            $this->data['msg'] = '上传文件失败';;
                        }
                    }
                }
                return $this->data;
            }
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