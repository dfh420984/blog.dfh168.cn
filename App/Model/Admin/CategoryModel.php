<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2018/12/29
 * Time: 10:37
 */

namespace App\Model\Admin;

use App\Model\BaseModel;
use  EasySwoole\EasySwoole\Config;

class CategoryModel extends BaseModel
{
    protected $id = null;
    protected $parent_id;
    protected $slug;
    protected $title;
    protected $content;
    protected $status;
    protected $time_create;
    protected $time_update;
    private $db = null;
    private $db_config = [];
    private $size = 20;

    public function __construct()
    {
        $this->db = $this->getMysqlPoolObj();
        $this->db_config = Config::getInstance()->getConf('mysql_table');
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getTimeCreate()
    {
        return $this->time_create;
    }

    /**
     * @param mixed $time_create
     */
    public function setTimeCreate($time_create): void
    {
        $this->time_create = $time_create;
    }

    /**
     * @return mixed
     */
    public function getTimeUpdate()
    {
        return $this->time_update;
    }

    /**
     * @param mixed $time_update
     */
    public function setTimeUpdate($time_update): void
    {
        $this->time_update = $time_update;
    }

    /**
     * @param $data
     * @return mixed
     * 添加分类
     */
    public function categoryAdd($data)
    {
        $this->db->insert($this->db_config['category_table'], $data);
        $res = $this->db->getInsertId();
        return $res;
    }

    /**
     * @param $data
     * @return mixed
     * 编辑帖子
     */
    public function categoryEdit($data)
    {
        $id = $data['id'];
        unset($data['id']);
        $res = $this->db->where('id', $id)->update($this->db_config['category_table'], $data);
        return $res;
    }

    /**
     * 获取帖子列表
     */
    public function categoryList($data=[])
    {
        $where = [
            'page' => 1,
            'size' => $this->size,
            'parent_id' => "",
            'status' => ""
        ];
        $offset = ($where['page'] - 1) * $this->size;
        $bindParams = [];
        $sql = "SELECT * FROM {$this->db_config['category_table']} WHERE 1=1";
        $where = array_merge($where, $data);
        if (is_numeric($where['parent_id'])) {
            $sql .= " AND p.parent_id = ?";
            $bindParams[] = $where['parent_id'];
        }
        if (is_numeric($where['status'])) {
            $sql .= " AND p.status = ?";
            $bindParams[] = $where['status'];
        }
        if (!isset($data['count'])) {
            $sql .= " LIMIT {$offset},{$this->size}";
        }
        $res = $this->db->rawQuery($sql, $bindParams);
        return $res;
    }

    public function __destruct()
    {
        $this->recycleMysqlPoolObj($this->db);
    }

}