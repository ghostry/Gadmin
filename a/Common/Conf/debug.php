<?php

return array(
//错误设置
    'ERROR_PAGE' => '', // 错误定向页面
    'SHOW_ERROR_MSG' => APP_DEBUG, // 显示错误信息
    'TRACE_EXCEPTION' => APP_DEBUG, // TRACE错误信息是否抛异常 针对trace方法
    'TRACE_MAX_RECORD' => 100, // 每个级别的错误信息 最大记录数
//日志设置
    'LOG_RECORD' => FALSE, // 默认不记录日志
    'LOG_TYPE' => 'File', // 日志记录类型 默认为文件方式
    'LOG_LEVEL' => 'EMERG,ALERT,CRIT,ERR,SQL', // 允许记录的日志级别
    'LOG_EXCEPTION_RECORD' => FALSE, // 是否记录异常信息日志
);
