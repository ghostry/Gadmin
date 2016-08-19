<?php

/**
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/09
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Controller;

use Think\Controller;

class QueueController extends Controller {

    private $model;

    public function __construct() {
        parent::__construct();
        function_exists('set_time_limit') && set_time_limit(0); //防止超时
        function_exists('ignore_user_abort') && ignore_user_abort(true); //断开后仍然执行完成
        $this->model = D('Queue');
    }

    /**
     * 执行
     */
    public function run() {
        D('Jobs')->run();
        $fen = date('YmdHi');
        while ($fen == date('YmdHi')) {
            $this->model->run();
            $time = 100;
            usleep($time * 1000);
        }
        exit('ok');
    }

}
