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

    public function onRequest(?string $action): ?bool
    {
        if (!parent::onRequest($action)) {
            return false;
        }
        return parent::onRequest($action); // TODO: Change the autogenerated stub
    }

    /**
     * 后台首页 dfh
     * Index constructor.
     */
    public function index() {
        $model = new IndexModel();
        $data = $model->index();
        return $this->writeJson($data["code"],$data["msg"],$data["data"]);
    }
}