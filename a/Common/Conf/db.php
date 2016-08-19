<?php

/**
 * 数据库设置
 */
return array(
    'DB_TYPE' => MYSQL_DB_TYPE, // 数据库类型
    'DB_HOST' => MYSQL_DB_HOST, // 服务器地址
    'DB_NAME' => MYSQL_DB_DATABASE, // 数据库名
    'DB_USER' => MYSQL_DB_USERNAME, // 用户名
    'DB_PWD' => MYSQL_DB_PASSWORD, // 密码
    'DB_PORT' => MYSQL_DB_PORT, // 端口
    'DB_PREFIX' => MYSQL_DB_PREFIX, // 数据库表前缀
    'DB_FIELDTYPE_CHECK' => !APP_DEBUG, // 是否进行字段类型检查
    'DB_FIELDS_CACHE' => 0, // 启用字段缓存
    'DB_CHARSET' => MYSQL_DB_CHARSET, // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE' => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE' => false, // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM' => 1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO' => '', // 指定从服务器序号
    'DB_SQL_BUILD_CACHE' => 1, // 数据库查询的SQL创建缓存
    'DB_SQL_BUILD_QUEUE' => 'File', // SQL缓存队列的缓存方式 支持 file xcache和apc
    'DB_SQL_BUILD_LENGTH' => 20, // SQL缓存的队列长度
    'DB_SQL_LOG' => 1, // SQL执行日志记录
    'DB_BIND_PARAM' => false, // 数据库写入数据自动参数绑定
    'DEFAULT_FILTER' => '', //过滤机制
);
