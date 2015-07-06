<?php

/**
 * @页面
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/04
 * @Copyright: blog.ghostry.cn
 */

namespace Home\Model;

use Think\Model;

class PageModel extends CommonModel {

//查
    public function f($options = '', $where = array()) {
        $where['type'] = $options;
        return $this->where($where)->find();
    }

}
