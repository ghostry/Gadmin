<?php

/**
 * 输出压缩
 */

namespace Common\Behavior;

class TssBehavior {

    // 行为扩展的执行入口必须是run
    public function run(&$content) {
        /* 去除html空格与换行 */
        $find = '/>\s+</';
        $replace = '><';
        $content = preg_replace($find, $replace, $content);
    }

}
