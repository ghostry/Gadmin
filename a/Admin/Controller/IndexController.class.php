<?php

/**
 * @后台首页
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/01
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Controller;

use Think\Controller;

class IndexController extends CommonController {

    /**
     * 后台首页
     */
    public function index() {
        if (function_exists('gd_info')) {
            $gd = gd_info();
            $gd = $gd['GD Version'];
        } else {
            $gd = '<span class="red">不支持</span>';
        }
        $info = array(
            'PHP版本' => PHP_VERSION,
            'MYSQL版本' => function_exists("mysql_close") ? mysql_get_client_info() : '<span class="red">不支持</span>',
            'GD库版本' => $gd,
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . "秒",
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            '服务器时间' => date("Y年n月j日 H:i:s"),
            '北京时间' => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600),
            '采集函数检测' => ini_get('allow_url_fopen') ? '支持' : '不支持',
            'register_globals' => get_cfg_var("register_globals") == "1" ? "ON" : '<span class="red">OFF</span>',
            'magic_quotes_gpc' => (1 === get_magic_quotes_gpc()) ? 'YES' : '<span class="red">NO</span>',
            'magic_quotes_runtime' => (1 === get_magic_quotes_runtime()) ? 'YES' : '<span class="red">NO</span>',
        );
        $this->assign('server_info', $info);
        $this->display();
    }

}
