<?php

/**
 * @前台基类
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/11
 * @Copyright: blog.ghostry.cn
 */

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller {

    protected $info; //信息
    protected $form; //表单
    protected $message; //提示
    protected $model; //模型

    public function __construct() {
        parent::__construct();
        $this->SystemInfo = D('System')->f('system');
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
