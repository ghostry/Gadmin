<?php

/**
 * 创建密码
 */
function createPassword($password) {
    if ($password != '') {
        return md5($password . MYSQL_DB_PREFIX . 'P@ssW0rd');
    } else {
        return $password;
    }
}
