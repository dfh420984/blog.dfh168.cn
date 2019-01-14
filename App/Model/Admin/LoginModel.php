<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2019/1/9
 * Time: 16:24
 */

namespace App\Model\Admin;

use App\Model\BaseModel;
use  EasySwoole\EasySwoole\Config;

class LoginModel extends BaseModel
{
    private $db = null;
    private $db_config = [];

    public function __construct()
    {
        $this->db = $this->getMysqlPoolObj();
        $this->db_config = Config::getInstance()->getConf('mysql_table');
    }

    public function verifyAccout($data)
    {
        $sql = "SELECT id,email,mobile,head_image,passwd FROM {$this->db_config['admin_table']} WHERE email = ? OR mobile = ?";
        $res = $this->db->rawQuery($sql, [$data['account'], $data['account']]);
        if (empty($res)) {
            return $this->returnData(1, '账号不存在', '');
        } else {
            $userInfo = $res[0];
            // password_hash('123456',PASSWORD_DEFAULT)
            if (password_verify($data['passwd'], $userInfo['passwd'])) {
                unset($userInfo['passwd']);
                return $this->returnData(0, 'ok', $userInfo);
            } else {
                return $this->returnData(1, '密码不正确', '');
            }
        }
    }

    public function __destruct()
    {
        $this->recycleMysqlPoolObj($this->db);
    }
}