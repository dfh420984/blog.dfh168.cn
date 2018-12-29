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
    protected $user_id;
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
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
    public function postAdd($data) {
        $this->db->insert($this->db_config['posts_table'], $data);
        $res = $this->db->getInsertId();
        return $res;
    }

    /**
     * @param $data
     * @return mixed
     * 编辑帖子
     */
    public function postEdit($data) {
        $id = $data['id'];
        unset($data['id']);
        $res = $this->db->where('id',$id)->update($this->db_config['posts_table'], $data);
        return $res;
    }

    public function __destruct()
    {
        $this->recycleMysqlPoolObj($this->db);
    }

}