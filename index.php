<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用入口文件
// 检测PHP环境
if (version_compare(PHP_VERSION, '5.3.0', '<'))
    die('require PHP > 5.3.0 !');

include_once 'config.ini.php';

define('HTML_PATH', RUNTIME_PATH . 'Html/');
define('DATA_PATH', ALL_DATA_PATH . 'Data/');
define('DATABASE_PATH', ALL_DATA_PATH . 'Database/');
define('UPLOAD_PATH', ALL_DATA_PATH . 'Upload/');
//检查目录存在，不存在创建
if (!is_dir(RUNTIME_PATH)) {
    mkdir(RUNTIME_PATH);
    // 写入禁止访问
    $filename = DATABASE_PATH . '.htaccess';
    $word = "RedirectMatch 301 ./(.*) /";
    $fh = fopen($filename, "w");
    fwrite($fh, $word);
    fclose($fh);
}
if (!is_dir(ALL_DATA_PATH)) {
    mkdir(ALL_DATA_PATH);
}
if (!is_dir(HTML_PATH)) {
    mkdir(HTML_PATH);
}
if (!is_dir(DATA_PATH)) {
    mkdir(DATA_PATH);
    // 写入禁止访问
    $filename = DATABASE_PATH . '.htaccess';
    $word = "RedirectMatch 301 ./(.*) /";
    $fh = fopen($filename, "w");
    fwrite($fh, $word);
    fclose($fh);
}
if (!is_dir(DATABASE_PATH)) {
    mkdir(DATABASE_PATH);
    // 写入禁止访问
    $filename = DATABASE_PATH . '.htaccess';
    $word = "RedirectMatch 301 ./(.*) /";
    $fh = fopen($filename, "w");
    fwrite($fh, $word);
    fclose($fh);
}
if (!is_dir(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH);
}
//检查是否调试模式
if (APP_DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
} else {
    ini_set('display_errors', 0);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
}
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pramga: no-cache");
// 引入ThinkPHP入口文件
require ThinkPHP_SYSTEM_PATH . 'ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单