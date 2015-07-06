<?php

/**
 * @管理员组
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/01
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Model;

use Think\Model;

class AdminRoleModel extends CommonModel {

    protected $tablenameCN = '管理员组';

    /**
     * 取得管理员组数组
     * @return array
     */
    public function get() {
	$r = $this->select();
	foreach ($r as $v) {
	    $arr[$v['id']] = $v['name'];
	}
	return $arr;
    }

    /**
     * 取得管理员组选择数组
     * @return array
     */
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

}
