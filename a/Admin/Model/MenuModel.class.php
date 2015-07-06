<?php

/**
 * @菜单
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/03
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Model;

use Think\Model;

class MenuModel extends CommonModel {

    protected $_auto = array(
	array('admins', 'createAdmins', 3, 'callback'),
    );

    public function createAdmins($admins) {
	return implode(',', $admins);
    }

    public function getMenu() {
	$t = $this->where(array('cid' => 0))->order('px desc,name asc')->select();
	foreach ($t as $value) {
	    $value['admins'] = explode(',', $value['admins']);
	    if (in_array(session('admin_role'), $value['admins'])) {
		$r[] = $value;
	    }
	}
	return $r;
    }

    public function getSubMenu($controller) {
	$cid = $this->where(array('controller' => $controller))->getField('id');
	$t = $this->where(array('cid' => $cid))->order('px desc,name asc')->select();
	foreach ($t as $value) {
	    $value['admins'] = explode(',', $value['admins']);
	    if (in_array(session('admin_role'), $value['admins'])) {
		$r[] = $value;
	    }
	}
	return $r;
    }

    public function getBreadcrumb($controller) {
	return $this->where(array('controller' => $controller))->getField('name');
    }

    public function getCid($id) {
	return $this->where(array('id' => $id))->getField('cid');
    }

//列
    public function l($options) {
	return $this->where(array('cid' => $options))->select();
    }

}
