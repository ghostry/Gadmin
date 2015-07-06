<?php

/**
 * @系统设置
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/01
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Controller;

use Think\Controller;

class SystemController extends CommonController {

    public function __construct() {
	parent::__construct();
	//exit(CONTROLLER_NAME);
	$this->model = D(CONTROLLER_NAME);
    }

    public function index() {
	if (IS_POST) {
	    if ($this->model->e('system')) {
		$this->success('修改成功!');
	    } else {
		$this->error('修改失败');
	    }
	    exit;
	}
	$this->form['site'] = array('text', array('name' => 'site', 'text' => '网站名称', 'type' => 'text'));
	$this->form['siteUrl'] = array('text', array('name' => 'siteUrl', 'text' => '网址', 'type' => 'url'));
	$this->form['keywords'] = array('text', array('name' => 'keywords', 'text' => '关键字', 'type' => 'text'));
	$this->form['description'] = array('textarea', array('name' => 'description', 'text' => '网站说明'));
	$this->assign('form', $this->form);
	$this->info = $this->model->f('system');
	$this->assign('info', $this->info);
	$this->display();
    }

    public function cache() {
	delDirAndFile(RUNTIME_PATH, TRUE);
	if (!is_dir(RUNTIME_PATH . 'Cache')) {
	    D('System')->log('清除缓存');
	    $this->success('清除成功！');
	    exit;
	} else {
	    $this->error('清除失败！');
	    exit;
	}
    }

    public function logs() {
	$name = I('get.admin');
	if ($name) {
	    $where['admin'] = array('like', "%$name%");
	}
	$weixinNum = I('get.addtime');
	if ($weixinNum) {
	    $where['addtime'] = array('between', array(date('Ymd000000', strtotime($weixinNum)), date('Ymd235959', strtotime($weixinNum))));
	}
	C('PAGE_SIZE', 20);
	$total = $this->model->lc($where);
	$page = new \Think\Page($total, C('PAGE_SIZE'));
	if ($total > C('PAGE_SIZE')) {
	    //$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
	    $page->setConfig('theme', '<ul class="pagination"><li class="disable">%HEADER%</li><li>%FIRST%</li><li>%UP_PAGE%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li></ul>');
	}
	$page = $page->show();
	$this->assign('page', $page ? $page : '');
	$this->assign('total', $total);
	//var_export($where);
	$p = I('p');
	$list = $this->model->logs($where, $p, C('PAGE_SIZE'));
	//echo $this->model->_sql();
	$this->assign('list', $list);
	$form['start'] = array('inline' => 1, 'method' => 'get');
	$form['button'] = array('button', array(
		'data' => array(
		    array('qingkong', '清空日志'),
		)
	));
	$form['admin'] = array('text', array('name' => 'admin', 'text' => '管理员', 'type' => 'text'));
	$form['addtime'] = array('text', array('name' => 'addtime', 'text' => '日期', 'type' => 'text'));
	$this->assign('form', $form);
	$_GET['addtime'] = $_GET['addtime'] ? $_GET['addtime'] : date('Y-m-d');
	$this->assign('info', $_GET);
	$this->display();
    }

    public function qingkong() {
	$this->model->qingkong();
	$this->redirect('logs');
    }

    public function logstong() {
	$m = M('logs');
	$weixinNum = I('get.addtime');
	if ($weixinNum) {
	    $where['addtime'] = array('between', array(date('Ymd000000', strtotime($weixinNum)), date('Ymd235959', strtotime($weixinNum))));
	    $list = $m->where($where)->group('admin')->field('admin,count(id) num')->select();
	    //echo $this->model->_sql();
	    $this->assign('list', $list);
	}
	$form['start'] = array('inline' => 1, 'method' => 'get');
	$form['addtime'] = array('text', array('name' => 'addtime', 'text' => '日期', 'type' => 'text'));
	$form['end'] = array('submit' => '统计');
	$this->assign('form', $form);
	$_GET['addtime'] = $_GET['addtime'] ? $_GET['addtime'] : date('Y-m-d');
	$this->assign('info', $_GET);
	$this->display();
    }

}
