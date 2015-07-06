<?php

/**
 * @管理员
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/01
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Model;

use Think\Model;

class AdminModel extends CommonModel {

    protected $tablenameCN = '管理员';
    protected $_validate = array(
	array('email', 'require', '账户必须！', 1, 'regex', 1),
	array('nickname', 'require', '昵称必须！', 1, 'regex', 1),
	array('password', 'require', '密码必须！', 1, 'regex', 1),
	array('role', 'require', '用户组必须！', 1, 'regex', 1),
	array('email', '', '账户已经存在！', 0, 'unique', 1),
    );
    protected $_auto = array(
	array('password', 'createPassword', 3, 'callback'),
	array('status', 'checkStatus', 3, 'callback'),
	array('password', '', 2, 'ignore'),
	array('email', '', 2),
	array('email', '', 2, 'ignore'),
	array('admin', 'returnAdmin', 3, 'callback'),
    );

    public function checkStatus($status) {
	return $status ? 1 : 0;
    }

    public function createPassword($password) {
	if ($password != '') {
	    return md5($password . MYSQL_DB_PREFIX . 'P@ssW0rd');
	} else {
	    return $password;
	}
    }

    public function login() {
	$where['email'] = I('post.email');
	$where['password'] = $this->createPassword(I('post.password'));
	$u = $this->where($where)->find();
	if ($u) {
	    if ($u['status']) {
		session('admin_id', $u['id']);
		session('admin_email', $u['email']);
		session('admin_nickname', $u['nickname']);
		session('admin_role', $u['role']);
		session('admin_teamId', $u['teamId']);
		cookie('admin_id', $u['id']);
		cookie('admin_email', $u['email']);
		cookie('admin_check', md5($u['password'] . date('Y-m')));
		//更新登陆时间
		$this->save(array('id' => $u['id'], 'logintime' => date('YmdHis')));
		$this->log('登陆');
	    }
	    return $u['status'];
	} else {
	    return FALSE;
	}
    }

    public function checklogin() {
	if (
		session('admin_id') &&
		session('admin_email') &&
		session('admin_nickname') &&
		session('admin_role')) {
	    return TRUE;
	}
	if (
		cookie('admin_id') &&
		cookie('admin_email') &&
		cookie('admin_check')) {
	    $u = $this->where(array('id' => cookie('admin_id'), 'email' => cookie('admin_email')))->find();
	    if (md5($u['password'] . date('Y-m')) == cookie('admin_check')) {
		session('admin_id', $u['id']);
		session('admin_email', $u['email']);
		session('admin_nickname', $u['nickname']);
		session('admin_role', $u['role']);
		session('admin_teamId', $u['teamId']);
		$this->log('记忆登陆');
		return TRUE;
	    }
	}
	return FALSE;
    }

}
