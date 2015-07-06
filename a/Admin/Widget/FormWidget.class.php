<?php

/**
 * @表单
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/01
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Widget;

use Think\Controller;

class FormWidget extends Controller {

    public function form($data) {
	if (!$data) {
	    return '';
	}
	$this->_form_start($data['start']);
	$this->assign('inline', $data['start']['inline']);
	unset($data['start']);
	$end = $data['end'];
	unset($data['end']);
	foreach ($data as $value) {
	    $this->$value[0]($value[1]);
	}
	$this->_form_end($end);
    }

    /**
     * 文件
     * 例：      $this->form['img'] = array('file', array('name' => 'img', 'text' => '网络结构图', 'type' => 'image', 'size' => '20480'));
     * @param type $value
     */
    public function file($value) {
	$this->assign($value);
	$this->display('Widget/file');
    }

    /**
     * datetimepicker
     * 例： $this->form['datetimepicker'] = array('datetimepicker', array('name' => 'name', 'text' => '日期','format'=>'yyyy-mm-dd'));
     * @param type $value
     */
    public function datetimepicker($value) {
	$this->assign($value);
	$this->display('Widget/datetimepicker');
    }

    /**
     * 文本
     * 例： $this->form['name'] = array('text', array('name' => 'name', 'text' => '大区名称', 'type' => 'text'));
     * @param type $value
     */
    public function text($value) {
	$this->assign($value);
	$this->display('Widget/input_text');
    }

    /**
     * 隐藏
     * 例： $this->form['admin'] = array('hidden', array('name' => 'admin'));
     * @param type $value
     */
    public function hidden($value) {
	$this->assign($value);
	$this->display('Widget/hidden');
    }

    /**
     * 文本区域
     * 例： 	$this->form['remark'] = array('textarea', array('name' => 'remark', 'text' => '备注'));
     * @param type $value
     */
    public function textarea($value) {
	$this->assign($value);
	$this->display('Widget/textarea');
    }

    /**
     * 色彩选择
     * 例： 	$this->form['zise'] = array('color', array('name' => 'zise', 'text' => '字色'));
     * @param type $value
     */
    public function color($value) {
	$this->assign($value);
	$this->display('Widget/color');
    }

    /**
     * 选择
     * 例: $this->form['engine'] = array('select', array(
      'name' => 'engine',
      'text' => '所属机房',
      ));
      $this->form['engine'][1]['data'] = D('Engine')->getSelect();
     * @param type $value
     */
    public function select($value) {
	$this->assign($value);
	$this->display('Widget/select');
    }

    /**
     * 选择地区
     * 例: $this->form['district'] = array('district', array(
      'name' => array(
      'province','city','district'
      ),
      'text' => '所属地区',
      ));
     * @param type $value
     */
    public function district($value) {
	$value['province'] = D('Province')->getSelect();
	$this->assign($value);
	$this->display('Widget/district');
    }

    /**
     * 复选框
     * 例：$this->form['status'] = array('checkbox', array(
      'data' => array(
      array('status', '完好'),
      )
      ));
     * @param type $value
     */
    public function checkbox($value) {
	$this->assign($value);
	$this->display('Widget/checkbox');
    }

    /**
     * 按钮
     * 例：$this->form['button'] = array('button', array(
      'data' => array(
      array('status', '完好','btn-default','button',false),
      )
      ));
     * @param type $value
     */
    public function button($value) {
	$this->assign($value);
	$this->display('Widget/button');
    }

    private function _form_start($value) {
	$this->assign($value);
	$this->display('Widget/form_start');
    }

    private function _form_end($value) {
	$this->assign($value);
	$this->display('Widget/form_end');
    }

}
