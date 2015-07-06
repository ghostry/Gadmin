<?php

/**
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/03
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Model;

use Think\Model;

class ProvinceModel extends CommonModel {

    protected $tablenameCN = '省';
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

    public function getSelect() {
	$r = $this->select();
	foreach ($r as $v) {
	    $arr[] = array($v['id'], $v['name']);
	}
	return $arr;
    }

    public function getRoleName($ids) {
	return $this->where(array('id' => array('in', $ids)))->select();
    }

    public function getDistrict($id) {
	$tmp2 = $this->table('g_city')->where(array('ProvinceID' => $id))->select();
	foreach ($tmp2 as $v) {
	    $tmp = $this->table('g_district')->where(array('CityID' => $v['id']))->select();
	    foreach ($tmp as $value) {
		$tmp1[] = $value['id'];
	    }
	}
	return $tmp1;
    }

}
