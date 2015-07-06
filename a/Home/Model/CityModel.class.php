<?php

/**
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/03
 * @Copyright: blog.ghostry.cn
 */

namespace Home\Model;

use Think\Model;

class CityModel extends CommonModel {

    protected $_auto = array(
        array('admin', 'returnAdmin', 3, 'callback'),
    );

    public function get() {
        $r = $this->select();
        foreach ($r as $v) {
            $arr[$v['id']] = $v['name'];
        }
        return $arr;
    }

    public function getSelect($where) {
        $r = $this->where($where)->select();
        foreach ($r as $v) {
            $arr[] = array($v['id'], $v['name']);
        }
        return $arr;
    }

    public function getRoleName($ids) {
        return $this->where(array('id' => array('in', $ids)))->select();
    }

}
