<?php

/**
 * @管理员
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/01
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Controller;

use Think\Controller;

class AdminController extends CommonController {

    public function __construct() {
        parent::__construct();
        $this->form['email'] = array('text', array('name' => 'email', 'text' => '账户', 'type' => 'email'));
        $this->form['nickname'] = array('text', array('name' => 'nickname', 'text' => '昵称', 'type' => 'text'));
        $this->form['password'] = array('text', array('name' => 'password', 'text' => '密码', 'type' => 'text', 'disabled' => 0));
        $this->form['role'] = array('select', array(
                'name' => 'role',
                'text' => '权限组',
        ));
        $this->form['role'][1]['data'] = D('AdminRole')->getSelect();
        $this->form['status'] = array('checkbox', array(
                'data' => array(
                    array('status', '启用'),
                ), 'class' => ''
        ));
        $this->form['remark'] = array('textarea', array('name' => 'remark', 'text' => '备注', 'class' => ''));
        $this->model = D(CONTROLLER_NAME);
    }

    protected function _index() {
        $this->assign('list', $this->model->l());
        $this->assign('role', D('AdminRole')->get());
    }

    /**
     * 后台登陆
     */
    public function login() {
        if (IS_POST) {
            if ($this->model->login()) {
                $this->redirect('Index/index');
            } else {
                $this->error('用户名密码错误，或账户被禁用');
            }
            exit;
        }
        $this->display();
    }

    /**
     * 后台退出
     */
    public function logout() {
        session(null);
        cookie(null, C('COOKIE_PREFIX'));
        $this->success('退出成功', U('login'));
    }

    /**
     * 权限管理
     */
    public function role($cid = 0) {
        $this->model = D('Menu');
        $this->assign('list', $this->model->l($cid));
        $this->display();
    }

    /**
     * 权限组编辑
     */
    public function redit($id) {
        if (!$id) {
            $this->error('参数不全');
            exit;
        }
        $this->model = D('Menu');
        if (IS_POST) {
            $_POST['id'] = $id;
            if (!$this->model->create()) {
                $this->error($this->model->getError());
                exit;
            }
            $this->message = array('text' => '修改成功', 'url' => U('role', array('cid' => D('Menu')->getCid($id))));
            $this->model->e();
            if (!$this->model->getError()) {
                $this->success($this->message['text'], $this->message['url']);
                exit;
            } else {
                $this->error($this->model->getError());
                exit;
            }
        }
        $this->form = array();
        $this->form['name'] = array('text', array('name' => 'name', 'text' => '名称', 'type' => 'text', 'disabled' => 1));
        $this->form['px'] = array('text', array('name' => 'px', 'text' => '排序', 'type' => 'number', 'disabled' => 0));
        $this->form['admins'] = array('select', array(
                'name' => 'admins',
                'text' => '权限组', 'class' => 'chosen-select', 'multiple' => '1'
        ));
        $this->form['admins'][1]['data'] = D('AdminRole')->getSelect();
        $this->info = $this->model->f($id);
        $this->assign('info', $this->info);
        $this->assign('form', $this->form);
        $this->display('add');
    }

    /**
     * 修改密码
     */
    public function changePassword() {
        $id = session('admin_id');
        if (IS_POST) {
            $_POST['id'] = $id;
            if (!$this->model->create()) {
                $this->error($this->model->getError());
                exit;
            }
            $this->message = array('text' => '修改成功', 'url' => U('changePassword'));
            $this->model->status = 1;
            $this->model->saveActionName = '修改密码';
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
        $this->form['email'][1]['disabled'] = 1;
        $this->form['nickname'][1]['disabled'] = 0;
        unset($this->info['password'], $this->form['role'], $this->form['status'], $this->form['teamId'], $this->form['remark'], $this->form['nickname']);
        $this->assign('info', $this->info);
        $this->assign('form', $this->form);
        $this->display('add');
    }

    protected function _add() {
        $this->assign('info', array('status' => 1));
    }

    protected function _edit() {
        $this->form['email'][1]['disabled'] = 1;
        $this->form['nickname'][1]['disabled'] = 0;
        if ($this->model->id == 1) {
            $this->form['role'][1]['disabled'] = 1;
            $this->form['status'][1]['data'][0][2] = 1;
            $this->form['status'][1]['disabled'] = 0;
        }
        unset($this->info['password']);
    }

    protected function _editPost() {
        if ($this->model->id == 1) {
            $this->model->role = 1;
            $this->model->status = 1;
        }
    }

    protected function _del() {
        //判断是否内置管理员
        if (in_array(1, $this->ids)) {
            $this->error('禁止删除内置管理员');
            exit;
        }
    }

}
