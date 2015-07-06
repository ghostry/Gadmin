<?php

/**
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/11
 * @Copyright: blog.ghostry.cn
 */

namespace Home\Controller;

use Think\Controller;

class IndexController extends CommonController {

    public function __construct() {
	$this->redirect('Admin/Index/index');
	//$this->redirect('Agent/reg');
    }

}
