<?php

/**
 * @后台基类
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/01
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller {

    protected $info; //信息
    protected $form; //表单
    protected $message; //提示
    protected $model; //模型

    public function __construct() {
	parent::__construct();
	//检查权限
	if (!(CONTROLLER_NAME == 'Admin' && ACTION_NAME == 'login')) {
	    if (!D('Admin')->checklogin()) {
		$this->redirect('Admin/login');
	    }
	    $menu = D('Menu')->getMenu();
	    //检查当前控制器是否有权限，没权限跳转到第一个有权限的页面
	    foreach ($menu as $key => $value) {
		$controller[] = $value['controller'];
	    }
	    if (!in_array(CONTROLLER_NAME, $controller)) {
		$submenu = D('Menu')->getSubMenu($menu[0]['controller']);
		$submenu = $menu[0]['controller'] . '/' . $submenu[0]['action'];
		//exit(CONTROLLER_NAME . '/' . ACTION_NAME);
		if (!in_array(CONTROLLER_NAME . '/' . ACTION_NAME, array('System/cache', 'Admin/changepassword', 'Admin/logout', 'Editer/upload', 'Index/rmuploadimg'))) {
		    $this->redirect($submenu);
		}
	    } else {
		$submenu = D('Menu')->getSubMenu(CONTROLLER_NAME);
		//检查子菜单权限
		foreach ($submenu as $key => $value) {
		    $action[] = $value['action'];
		}
		if (!in_array(ACTION_NAME, $action) && D('Menu')->where(array('action' => ACTION_NAME))->count() > 0) {
		    $submenu = CONTROLLER_NAME . '/' . $submenu[0]['action'];
		    //exit(CONTROLLER_NAME . '/' . ACTION_NAME);
		    if (!in_array(CONTROLLER_NAME . '/' . ACTION_NAME, array('System/cache', 'Admin/changepassword', 'Admin/logout', 'Editer/upload', 'Index/rmuploadimg'))) {
			//echo $submenu;
			$this->redirect($submenu);
		    }
		}
	    }
	}
	$this->admin_role = session('admin_role');
	$this->admin_teamId = session('admin_teamId');
	$this->assign('menu', $menu);
	$this->assign('submenu', D('Menu')->getSubMenu(CONTROLLER_NAME));
	$this->assign('breadcrumb', D('Menu')->getBreadcrumb(CONTROLLER_NAME));
	$this->SystemInfo = D('System')->f('system');
    }

    public function index() {
	$this->_index();
	$this->display();
    }

    public function add() {
	if (IS_AJAX) {
	    if (!$this->model->create()) {
		$this->r($this->model->getError());
	    }
	    $this->message = array('text' => '添加成功');
	    $this->_addAjax();
	    $ok = $this->model->a();
	    if ($ok) {
		$this->r($this->message['text'], 1, $this->message['url']);
	    } else {
		$this->r($this->model->getError());
	    }
	}
	if (IS_POST) {
	    if (!$this->model->create()) {
		$this->error($this->model->getError());
		exit;
	    }
	    $this->message = array('text' => '添加成功');
	    $this->_addPost();
	    $ok = $this->model->a();
	    if ($ok) {
		$this->success($this->message['text'], $this->message['url']);
	    } else {
		$this->error($this->model->getError());
	    }
	    exit;
	}
	$this->_add();
	$this->assign('form', $this->form);
	$this->display();
    }

    public function edit($id) {
	if (!$id) {
	    $this->error('参数不全');
	    exit;
	}
	if (IS_AJAX) {
	    $this->_editAjax();
	    exit;
	}
	if (IS_POST) {
	    $_POST['id'] = $id;
	    if (!$this->model->create()) {
		$this->error($this->model->getError());
		exit;
	    }
	    $this->message = array('text' => '修改成功', 'url' => U('index'));
	    $this->_editPost();
	    $this->model->e();
	    if (!$this->model->getError()) {
		$this->success($this->message['text'], $this->message['url']);
		exit;
	    } else {
		$this->error($this->model->getError());
		exit;
	    }
	}
	$this->info = $this->model->f($id);
	$this->_edit();
	$this->assign('info', $this->info);
	$this->assign('form', $this->form);
	$this->display('add');
    }

    public function del($id = 0) {
	$this->message = array('text' => '删除成功', 'url' => U('index'));
	if ($id) {
	    $ids = array($id);
	} else {
	    $ids = I('post.id');
	}
	$this->ids = $ids;
	$where['id'] = array('in', $ids);
	$this->_del();
	$ok = $this->model->d($where);
	if ($ok) {
	    if (IS_AJAX) {
		$this->r($this->message['text'], 1, $this->message['url']);
	    } else {
		$this->success($this->message['text'], $this->message['url']);
	    }
	} else {
	    if (IS_AJAX) {
		$this->r($this->model->getError());
	    } else {
		$this->error($this->model->getError());
	    }
	}
    }

    protected function _index() {

    }

    protected function _add() {

    }

    protected function _addAjax() {

    }

    protected function _addPost() {

    }

    protected function _edit() {

    }

    protected function _editAjax() {

    }

    protected function _editPost() {

    }

    protected function _del() {

    }

    protected function r($info, $status = 0, $url = '') {
	if (!is_array($info)) {
	    $this->ajaxReturn(array('status' => $status, 'info' => $info, 'url' => $url));
	} else {
	    $this->ajaxReturn($info);
	}
	exit;
    }

}
