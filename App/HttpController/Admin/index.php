<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/25
 * Time: 18:01
**/

class Index extends Base {

    /**
     * 后台首页
     * Index constructor.
     */
    public function index() {
        $data = [
            'article_num' => 0, //文章数量
            'category_num' => 0, //分类数量
            'comment_num' => 0, //评论数量
            'wait_verify_num' => 0, //评论待审核数量
        ];

    }
}