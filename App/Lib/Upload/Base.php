<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/19
 * Time: 22:01
 */
namespace App\Lib\Upload;

class Base {

    public $type = '';

    public function __construct($request)
    {
        $this->request = $request;
        $files = $this->request->getSwooleRequest()->files;
        $types = array_keys($files);
        $this->type = $types[0];
    }

    public function upload() {
        if ($this->type != $this->fileType) {
            return false;
        }
        $vedios = $this->request()->getUploadedFile($this->type);
        $this->size = $vedios->getSize();
        $this->fileName = $vedios->getClientFilename();
        $this->mediaMimeType = $vedios->getClientMediaType();
        $this->checkSize();
    }


    public function checkMimeType() {

    }

    public function checkSize() {
        if (empty($this->size)) {
            return false;
        }
    }
}