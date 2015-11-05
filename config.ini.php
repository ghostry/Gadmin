<?php

/**
 * 配置文件
 *
 */
//调试模式
define('APP_DEBUG', 1);
//URL模式，0，普通，1,PATHINFO，2,伪静态，3,兼容
define('URL_MODUS', 2);
//定义数据库参数
define('MYSQL_DB_HOST', 'localhost');
define('MYSQL_DB_PORT', 3306);
define('MYSQL_DB_USERNAME', 'a');
define('MYSQL_DB_PASSWORD', 'pezuzubub');
define('MYSQL_DB_CHARSET', 'utf8');
define('MYSQL_DB_DATABASE', 'zadmin_a');
//微信api
define('Weixin_appid', 'Weixin_appid');
define('Weixin_appsecret', 'Weixin_appsecret');
define('Weixin_token', 'Weixin_token');
define('Weixin_encodingaeskey', 'Weixin_encodingaeskey');

//以下内容尽量不编辑
// 定义应用目录
define('APP_PATH', './a/');
//框架目录
define('ThinkPHP_SYSTEM_PATH', 't/');
//运行路径
define('RUNTIME_PATH', 'Temp/');
//数据路径
define('ALL_DATA_PATH', 'Data/');

define('MYSQL_DB_PREFIX', 'g_');
define('MYSQL_DB_TYPE', 'mysqli');

