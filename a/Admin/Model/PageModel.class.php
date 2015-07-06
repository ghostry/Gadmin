<?php

/**
 * @页面
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/04
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Model;

use Think\Model;

class PageModel extends CommonModel {

    protected $tablenameCN = '单页';
    protected $_auto = array(
	array('admin', 'returnAdmin', 3, 'callback'),
    );

//查
    public function f($options = '', $where = array()) {
	$where['type'] = $options;
	return $this->where($where)->find();
    }

    public function e($data = '', $options = array()) {
	$where['type'] = $data;
	$ok = $this->where($where)->save();
	return $ok;
    }

    public function findfile($url) {
	$where['text'] = array('like', "%$url%");
	$r = $this->where($where)->count();
	//echo $this->_sql();
	return $r;
    }

}
