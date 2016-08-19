<?php

// 应用入口文件
/**
 * 以下内容尽量不编辑
 */
// 检测PHP环境
if (version_compare(PHP_VERSION, '5.3.0', '<'))
    die('require PHP > 5.3.0 !');

include_once 'config.ini.php';

// 定义应用目录
define('APP_PATH', './a/');
//框架目录
define('ThinkPHP_SYSTEM_PATH', 't/');
define('MYSQL_DB_PREFIX', 'g_');
define('MYSQL_DB_TYPE', 'mysqli');

define('HTML_PATH', RUNTIME_PATH . 'Html/');
define('DATA_PATH', ALL_DATA_PATH . 'Data/');
define('DATABASE_PATH', ALL_DATA_PATH . 'Database/');
define('UPLOAD_PATH', ALL_DATA_PATH . 'Upload/');

/**
 * 配置结束，进行初始化
 */
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
// 引入ThinkPHP入口文件
require ThinkPHP_SYSTEM_PATH . 'ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单