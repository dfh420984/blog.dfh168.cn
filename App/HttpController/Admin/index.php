<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/25
 * Time: 18:01
**/
namespace  App\HttpController\Admin;
use App\HttpController\Base;
use App\Model\Admin\IndexModel;

class Index extends Base {

    /**
     * 后台首页
     * Index constructor.
     */
    public function index() {

        $model = IndexModel::getInstance();
        $data = $model->index();
        return $this->writeJson($data["code"],$data["msg"],$data["data"]);
    }
}