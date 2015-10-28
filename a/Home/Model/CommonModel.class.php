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

}
