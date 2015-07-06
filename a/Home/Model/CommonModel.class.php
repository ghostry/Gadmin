<?php

/**
 * @基础model
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/01
 * @Copyright: blog.ghostry.cn
 */

namespace Home\Model;

use Think\Model;

class CommonModel extends Model {

    protected $action; //当前操作
    protected $status; //操作状态

//增

    public function a($data = '', $options = array(), $replace = false) {
	$ok = $this->add($data, $options, $replace);
	return $ok;
    }

//删
    public function d($options = array()) {
	if (!is_array($options)) {
	    $ok = $this->delete($options);
	} else {
	    $ok = $this->where($options)->delete();
	}
	return $ok;
    }

//改
    public function e($data = '', $options = array()) {
	$ok = $this->save($data, $options);
	return $ok;
    }

//列
    public function l($options = array()) {
	return $this->select($options);
    }

//列表
    public function lp($where = array(), $page = 0, $limit = 10, $order = 'addtime desc') {
	return $this->where($where)->order($order)->limit($limit)->page($page)->select();
    }

//查
    public function f($options = array()) {
	return $this->find($options);
    }

//总量
    public function c($where) {
	return $this->where($where)->count();
    }

}
