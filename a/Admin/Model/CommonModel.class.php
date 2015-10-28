<?php

/**
 * @基础model
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/05
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Model;

use Think\Model;

class CommonModel extends Model {

    protected $action; //当前操作
    protected $status; //操作状态
    protected $tablenameCN = '表名';
    public $addActionName = '添加';
    public $saveActionName = '编辑';
    public $delActionName = '删除';

    /**
     * 改表名
     */
    public function setTableNameCN($value) {
        $this->tablenameCN = $value;
        return $this;
    }

    /**
     * 增
     */
    public function a($data = '', $options = array(), $replace = false) {
        $ok = $this->add($data, $options, $replace);
        if ($ok) {
            $this->log($ok, $this->addActionName);
        }
        return $ok;
    }

    /**
     * 删
     */
    public function d($options = array()) {
        if (!is_array($options)) {
            $ok = $this->delete($options);
        } else {
            $ok = $this->where($options)->delete();
        }
        if ($ok) {
            $this->log(var_export($options, TRUE) . ' ', $this->delActionName);
        }
        return $ok;
    }

    /**
     * 改
     */
    public function e($data = '', $options = array()) {
        $id = $this->data[$this->pk];
        $ok = $this->save($data, $options);
        if ($ok) {
            $id = $id ? $id : $data[$this->pk];
            $this->log($id, $this->saveActionName);
        }
        return $ok;
    }

    /**
     * 列
     */
    public function l($options = array()) {
        return $this->select($options);
    }

    /**
     * 条件列
     */
    public function w($options = array(), $order = '') {
        return $this->where($options)->order($order)->select();
    }

    /**
     * 列表
     */
    public function lp($where = array(), $page = 0, $limit = 10, $order = '') {
        return $this->where($where)->order($order)->limit($limit)->page($page)->select();
    }

    /**
     * 查
     */
    public function f($options = array(), $where = array()) {
        return $this->where($where)->find($options);
    }

    /**
     * 总量
     */
    public function c($where = array()) {
        return $this->where($where)->count();
    }

    /**
     * 日志总量
     */
    public function lc($where = array()) {
        return M('logs')->where($where)->count();
    }

    /**
     * 日志列表
     */
    public function logs($where = array(), $page = 0, $limit = 10, $order = '') {
        return M('logs')->where($where)->order($order)->limit($limit)->page($page)->select();
    }

    /**
     * 插入日志
     */
    public function log($value = '', $des = '') {
        return M('logs')->data(array(
                    'model' => CONTROLLER_NAME ? CONTROLLER_NAME : 'CONTROLLER_NAME',
                    'action' => ACTION_NAME ? ACTION_NAME : 'ACTION_NAME',
                    'admin' => $this->returnAdmin() ? $this->returnAdmin() : 'admin',
                    'tablenameCN' => $this->tablenameCN ? $this->tablenameCN : '表名',
                    'tablename' => $this->name ? $this->name : 'tablename',
                    'value' => $value ? $value : 'value',
                    'des' => $des ? $des : 'des'
                ))->add();
    }

    /**
     * 返回当前管理员名称
     */
    public function returnAdmin() {
        return session('admin_nickname');
    }

}
