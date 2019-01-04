<?php
/**
 * Created by PhpStorm.
 * User: duanfuhao
 * Date: 2019/1/3
 * Time: 10:55
 */

namespace App\HttpController\Utility;

class Commen
{

    /**
     * @param $arr
     * @param int $pid
     * @param int $level
     * @return array
     * 获取分类树
     */
    public function subTree($arr, $pid = 0, $level = 1)
    {
        foreach ($arr as $key => $val) {
            if ($val['parent_id'] == $pid) {
                $val['level'] = $level;
                $this->newArr[] = $val;
                unset($arr[$key]);
                $this->subTree($arr, $val['id'], $level+1);
            }
        }
        return $this->newArr;
    }

    /**
     * @param $arr
     * @param int $id
     * @return array
     */
    public function findson($arr, $id = 0)
    {
        //数组循环一遍，谁的parent的值 = $id ,谁就是他的儿子
        $sons = array();    //子栏目数组
        foreach ($arr as $v) {
            if ($v['parent_id'] == $id) {
                $sons[] = $v;
            }
        }
        return $sons;
    }
}