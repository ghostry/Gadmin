<?php

/**
 * 配置文件
 *
 */
//调试模式
define('APP_DEBUG', 1);

/**
 * 网址
 */
define('WEB_URL', 'http://你的域名');
//URL模式，0，普通，1,PATHINFO，2,伪静态，3,兼容
define('URL_MODUS', 2);

/**
 * 定义数据库参数
 */
define('MYSQL_DB_HOST', 'localhost');
define('MYSQL_DB_PORT', 3306);
define('MYSQL_DB_USERNAME', 'a');
define('MYSQL_DB_PASSWORD', 'pezuzubub');
define('MYSQL_DB_CHARSET', 'utf8');
define('MYSQL_DB_DATABASE', 'zadmin_a');

/**
 * 微信api
 */
define('Weixin_appid', 'Weixin_appid');
define('Weixin_appsecret', 'Weixin_appsecret');
define('Weixin_token', 'Weixin_token');
define('Weixin_encodingaeskey', 'Weixin_encodingaeskey');

/**
 * 缓存类型,支持 File|Memcache
 */
define('DATA_CACHE_TYPE', 'File');
//define('MEMCACHE_HOST', '10.144.177.59');

/**
 * 短信平台接口
 */
define('SMS_USER', '账号');
define('SMS_PASS', '密码');
define('SMS_SIGN', '签名');

/**
 * 阿里大鱼短信app
 */
define('DaYu_SMS_USER', '用户');
define('DaYu_SMS_PASS', '密文');
define('DaYu_SMS_SIGN', '签名');

/**
 * 个推
 */
define('APPKEY', 'xxxxx');
define('APPID', 'xxxxx');
define('MASTERSECRET', 'xxxxx');
//http的域名
define('HOST', 'http://sdk.open.api.igexin.com/apiex.htm');
//https的域名
//define('HOST','https://api.getui.com/apiex.htm');
define('CID', '');
//接口代理注册开关
define('Api_Agent_Reg', 1);

/**
 * 运行路径
 */
define('RUNTIME_PATH', 'Temp/');

/**
 * 数据路径
 */
define('ALL_DATA_PATH', 'Data/');

/**
 * 支付宝和微信支付，
 * 支付宝配置在a/Common/Conf/alipay.php
 * 微信在a/Vendor/Wxpay/WxPayConfig.php
 */
define('CallBack_URL', 'http://支付宝微信回调独立域名');
