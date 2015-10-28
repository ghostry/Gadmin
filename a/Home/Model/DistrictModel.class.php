<?php

/**
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/03
 * @Copyright: blog.ghostry.cn
 */

namespace Home\Model;

use Think\Model;

class DistrictModel extends CommonModel {

    protected $_auto = array(
        array('admin', 'returnAdmin', 3, 'callback'),
    );

    /**
     * 取县区
     */
    public function get() {
        $r = $this->select();
        foreach ($r as $v) {
            $arr[$v['id']] = $v['name'];
        }
        return $arr;
    }

    /**
     * 取得选择数组
     */
    public function getSelect($where) {
        $r = $this->where($where)->select();
        foreach ($r as $v) {
            $arr[] = array($v['id'], $v['name']);
        }
        return $arr;
    }

}
