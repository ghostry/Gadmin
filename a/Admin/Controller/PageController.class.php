<?php

/**
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/01
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Controller;

use Think\Controller;

class PageController extends CommonController {

    public function __construct() {
	parent::__construct();
	$this->form['title'] = array('text', array('name' => 'title', 'text' => '页面名称', 'type' => 'text'));
	$this->form['text'] = array('textarea', array('name' => 'text', 'text' => '内容', 'class' => 'kindeditor'));
	$this->model = D(CONTROLLER_NAME);
    }

    protected function _index() {
	$name = I('get.title');
	if ($name) {
	    $where['title'] = array('like', "%$name%");
	}
	C('PAGE_SIZE', 20);
	$total = $this->model->c($where);
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
	$list = $this->model->lp($where, $p, C('PAGE_SIZE'));
	$this->assign('list', $list);
	$form['start'] = array('inline' => 1, 'method' => 'get');
	$form['title'] = array('text', array('name' => 'title', 'text' => '标题', 'type' => 'text'));
	$this->assign('form', $form);
	$this->assign('info', $_GET);
    }

}
