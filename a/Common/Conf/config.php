<?php

return array(
//应用设定
    'APP_FILE_CASE' => false, // 是否检查文件的大小写 对Windows平台有效
    'APP_SUB_DOMAIN_DEPLOY' => false, // 是否开启子域名部署
    'APP_SUB_DOMAIN_RULES' => array(), // 子域名部署规则
    'APP_DOMAIN_SUFFIX' => '', // 域名后缀 如果是com.cn net.cn 之类的后缀必须设置
    'ACTION_SUFFIX' => '', // 操作方法后缀
    'MULTI_MODULE' => true, // 是否允许多模块 如果为false 则必须设置 DEFAULT_MODULE
//默认设定
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'DEFAULT_THEME' => 'default', // 默认模板主题名称
    'DEFAULT_MODULE' => 'Home', // 默认模块
    'TAGLIB_BEGIN' => '^(',
    'TAGLIB_END' => ')^',
    'DEFAULT_CHARSET' => 'utf-8', // 默认输出编码
    'DEFAULT_TIMEZONE' => 'PRC', // 默认时区
    'DEFAULT_AJAX_RETURN' => 'JSON', // 默认AJAX 数据返回格式,可选JSON XML ...
    'DEFAULT_JSONP_HANDLER' => 'jsonpReturn', // 默认JSONP格式返回的处理方法
    'DEFAULT_FILTER' => 'htmlspecialchars', // 默认参数过滤方法 用于I函数...
    'PAGE_SIZE' => 10,
//Cookie设置
    'COOKIE_EXPIRE' => 0, // Cookie有效期
    'COOKIE_DOMAIN' => '', // Cookie有效域名
    'COOKIE_PATH' => '/', // Cookie路径
    'COOKIE_PREFIX' => MYSQL_DB_PREFIX, // Cookie前缀 避免冲突
//数据库设置
    'DB_TYPE' => MYSQL_DB_TYPE, // 数据库类型
    'DB_HOST' => MYSQL_DB_HOST, // 服务器地址
    'DB_NAME' => MYSQL_DB_DATABASE, // 数据库名
    'DB_USER' => MYSQL_DB_USERNAME, // 用户名
    'DB_PWD' => MYSQL_DB_PASSWORD, // 密码
    'DB_PORT' => MYSQL_DB_PORT, // 端口
    'DB_PREFIX' => MYSQL_DB_PREFIX, // 数据库表前缀
    'DB_FIELDTYPE_CHECK' => !APP_DEBUG, // 是否进行字段类型检查
    'DB_FIELDS_CACHE' => APP_DEBUG, // 启用字段缓存
    'DB_CHARSET' => MYSQL_DB_CHARSET, // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE' => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE' => false, // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM' => 1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO' => '', // 指定从服务器序号
    'DB_SQL_BUILD_CACHE' => !APP_DEBUG, // 数据库查询的SQL创建缓存
    'DB_SQL_BUILD_QUEUE' => 'file', // SQL缓存队列的缓存方式 支持 file xcache和apc
    'DB_SQL_BUILD_LENGTH' => 20, // SQL缓存的队列长度
    'DB_SQL_LOG' => APP_DEBUG, // SQL执行日志记录
    'DB_BIND_PARAM' => false, // 数据库写入数据自动参数绑定
    'DEFAULT_FILTER' => '', //过滤机制
//数据缓存设置
    'DATA_CACHE_TIME' => 2, // 数据缓存有效期 0表示永久缓存
    'DATA_CACHE_COMPRESS' => false, // 数据缓存是否压缩缓存
    'DATA_CACHE_CHECK' => false, // 数据缓存是否校验缓存
    'DATA_CACHE_PREFIX' => MYSQL_DB_PREFIX, // 缓存前缀
    'DATA_CACHE_TYPE' => 'File', // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
    'DATA_CACHE_PATH' => TEMP_PATH, // 缓存路径设置 (仅对File方式缓存有效)
    'DATA_CACHE_SUBDIR' => false, // 使用子目录缓存 (自动根据缓存标识的哈希创建子目录)
    'DATA_PATH_LEVEL' => 1, // 子目录缓存级别
//错误设置
    'ERROR_MESSAGE' => '页面错误！请稍后再试～', //错误显示信息,非调试模式有效
    'ERROR_PAGE' => '', // 错误定向页面
    'SHOW_ERROR_MSG' => APP_DEBUG, // 显示错误信息
    'TRACE_EXCEPTION' => APP_DEBUG, // TRACE错误信息是否抛异常 针对trace方法
    'TRACE_MAX_RECORD' => 100, // 每个级别的错误信息 最大记录数
//日志设置
    'LOG_RECORD' => FALSE, // 默认不记录日志
    'LOG_TYPE' => 'File', // 日志记录类型 默认为文件方式
    'LOG_LEVEL' => 'EMERG', // 允许记录的日志级别
    'LOG_EXCEPTION_RECORD' => FALSE, // 是否记录异常信息日志
//SESSION设置
    'SESSION_AUTO_START' => true, // 是否自动开启Session
    'SESSION_OPTIONS' => array(), // session 配置数组 支持type name id path expire domain 等参数
    'SESSION_TYPE' => '', // session hander类型 默认无需设置 除非扩展了session hander驱动
    'SESSION_PREFIX' => MYSQL_DB_PREFIX, // session 前缀
//模板引擎设置
    'TMPL_CONTENT_TYPE' => 'text/html', // 默认模板输出类型
    'TMPL_ACTION_ERROR' => 'Public:error', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS' => 'Public:success', // 默认成功跳转对应的模板文件
    //'TMPL_EXCEPTION_FILE' => THINK_PATH . 'Tpl/think_exception.tpl', // 异常页面的模板文件
    'TMPL_EXCEPTION_FILE' => 'Public/exception.html', // 异常页面的模板文件
    'TMPL_DETECT_THEME' => false, // 自动侦测模板主题
    'TMPL_TEMPLATE_SUFFIX' => '.html', // 默认模板文件后缀
//URL设置
    'URL_CASE_INSENSITIVE' => true, // 默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL' => URL_MODUS, // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    'URL_PATHINFO_DEPR' => '/', // PATHINFO模式下，各参数之间的分割符号
    'URL_PATHINFO_FETCH' => 'ORIG_PATH_INFO,REDIRECT_PATH_INFO,REDIRECT_URL', // 用于兼容判断PATH_INFO 参数的SERVER替代变量列表
    'URL_REQUEST_URI' => 'REQUEST_URI', // 获取当前页面地址的系统变量 默认为REQUEST_URI
    'URL_HTML_SUFFIX' => 'html|json', // URL伪静态后缀设置
    //'URL_DENY_SUFFIX' => 'ico|png|gif|jpg', // URL禁止访问的后缀设置
    'URL_PARAMS_BIND' => true, // URL变量绑定到Action方法参数
    'URL_PARAMS_BIND_TYPE' => 0, // URL变量绑定的类型 0 按变量名绑定 1 按变量顺序绑定
    'URL_404_REDIRECT' => '', // 404 跳转页面 部署模式有效
    'URL_ROUTER_ON' => false, // 是否开启URL路由
    'URL_ROUTE_RULES' => array(), // 默认路由规则 针对模块
    'URL_MAP_RULES' => array(), // URL映射定义规则
    'AUTOLOAD_NAMESPACE' => array(
        'Lib' => APP_PATH . 'Lib',
    )
);
