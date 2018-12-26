<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/25
 * Time: 18:01
 **/

namespace App\Model\Admin;

use App\Model\BaseModel;
use  EasySwoole\EasySwoole\Config;
use EasySwoole\Component\Singleton;

class IndexModel extends BaseModel
{
    use Singleton;
    /**
     * 后台首页逻辑
     * Index constructor.
     */
    protected $db = null;
    protected $db_config = [];
    protected $data = [
        'article_num' => 0, //文章数量
        'article_draft_num' => 0, //文章草稿数量
        'category_num' => 0, //分类数量
        'comment_num' => 0, //评论数量
        'verify_comment_num' => 0, //评论待审核数量
    ];

    private function __construct()
    {
        $this->db = $this->getMysqlPoolObj();
        $this->db_config = Config::getInstance()->getConf('mysql_table');
    }

    public function index()
    {
        $data = Array(
            "code" => 0,
            "msg" => 'ok',
            "data" => ''
        );
        try {
            //获取文章数量
            $this->getPostsData();
            //获取分类数量
            $this->getCategoryData();
            //获取评论数量
            $this->getCommentsData();
            $data['data'] = $this->data;
        } catch (\Exception $e) {
            $data["code"] = 1;
            $data["msg"] = $e->getMessage();
        }
        return $data;
    }

    /**
     * 获取文章数据
     */
    public function getPostsData()
    {
        $table_name = $this->db_config['posts_table'];
        $data = $this->db->get($table_name);
        if(!empty($data)) {
            foreach ($data as $k => $v) {
                if ($v['status'] == 1) {
                    $this->data['article_num'] += 1;
                } elseif ($v['status'] == 0) {
                    $this->data['article_draft_num'] += 1;
                }
            }
        }
        return true;
    }

    /**
     * 获取分类数据
     */
    public function getCategoryData()
    {
        $table_name = $this->db_config['category_table'];
        $data = $this->db->get($table_name);
        $this->data['category_num'] += count((array)$data);
        return true;
    }

    /**
     * 获取评论数据
     */
    public function getCommentsData()
    {
        $table_name = $this->db_config['comments_table'];
        $data = $this->db->get($table_name);
        if(!empty($data)) {
            foreach ($data as $k=>$v) {
                if ($v['status'] == 1) {
                    $this->data['comment_num'] += 1;
                } elseif ($v['status'] == 0) {
                    $this->data['verify_comment_num'] += 1;
                }
            }
        }
        return true;
    }

    public function __destruct()
    {
        $this->recycleMysqlPoolObj($this->db);
    }
}