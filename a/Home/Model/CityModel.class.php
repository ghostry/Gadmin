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

    /**
     * 取得城市
     */
    public function get() {
        $r = $this->select();
        foreach ($r as $v) {
            $arr[$v['id']] = $v['name'];
        }
        return $arr;
    }

    /**
     * 取得选择组
     */
    public function getSelect($where) {
        $r = $this->where($where)->select();
        foreach ($r as $v) {
            $arr[] = array($v['id'], $v['name']);
        }
        return $arr;
    }

    /**
     * 取得其下地区
     */
    public function getDistrict($id) {
        $tmp = $this->table('g_district')->where(array('CityID' => $id))->select();
        foreach ($tmp as $value) {
            $tmp1[] = $value['id'];
        }
        return $tmp1;
    }

}
