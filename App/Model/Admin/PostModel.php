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

class PostModel extends BaseModel
{
    protected $id = null;
    protected $admin_id;
    protected $cat_id;
    protected $title;
    protected $slug;
    protected $image;
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAdminId()
    {
        return $this->admin_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setAdminId($admin_id): void
    {
        $this->admin_id = $admin_id;
    }

    /**
     * @return mixed
     */
    public function getCatId()
    {
        return $this->cat_id;
    }

    /**
     * @param mixed $cat_id
     */
    public function setCatId($cat_id): void
    {
        $this->cat_id = $cat_id;
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
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
     * 添加帖子
     */
    public function postAdd($data)
    {
        try {
            if (isset($data['id'])) {
                unset($data['id']);
            }
            $this->db->insert($this->db_config['posts_table'], $data);
            $res = $this->db->getInsertId();
            return $res;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $data
     * @return mixed
     * 编辑帖子
     */
    public function postEdit($data)
    {
        $id = $data['id'];
        unset($data['id']);
        $res = $this->db->where('id', $id)->update($this->db_config['posts_table'], $data);
        return $res;
    }

    /**
     * 获取帖子列表
     */
    public function postList($data = [])
    {
        $where = [
            "id" => 0,
            'page' => 1,
            'size' => $this->size,
            'cat_id' => 0,
            'status' => ""
        ];
        $where = array_merge($where, $data);
        $offset = ($where['page'] - 1) * $where['size'];
        $bindParams = [];
        if (!isset($data['count'])) {
            $field = "p.id,
                p.title,
                p.time_create,
                p.image,
                p.slug,
                p.cat_id,
                p.admin_id,
                p.content as p_content,
                p.status,
                CASE p.`status`
            WHEN 0 THEN
                '草稿'
            WHEN 1 THEN
                '已发布'
            WHEN 2 THEN
                '已删除'
            END AS `status_name`,
             a.email,
             a.mobile,
             c.content
            ";
            $sql = "SELECT {$field}";
        } else {
            $sql = "SELECT count(p.id) as total";
        }
        $sql .= " FROM
                {$this->db_config['posts_table']} AS p
            INNER JOIN {$this->db_config['admin_table']} AS a ON p.admin_id = a.id
            INNER JOIN {$this->db_config['category_table']} AS c ON p.cat_id = c.id WHERE 1=1";
        if (!empty($where['id'])) {
            $sql .= " AND p.id = ?";
            $bindParams[] = $where['id'];
        }
        if (!empty($where['cat_id'])) {
            $sql .= " AND p.cat_id = ?";
            $bindParams[] = $where['cat_id'];
        }
        if (is_numeric($where['status'])) {
            $sql .= " AND p.status = ?";
            $bindParams[] = $where['status'];
        }
        if (!isset($data['count'])) {
            $sql .= " LIMIT {$offset},{$where['size']}";
        }
        $res = $this->db->rawQuery($sql, $bindParams);
        return $res;
    }

    public function postDel($id)
    {
        $res = $this->db->where('id', $id)->delete($this->db_config['posts_table'],1);
        return $res;
    }

    public function __destruct()
    {
        $this->recycleMysqlPoolObj($this->db);
    }

}