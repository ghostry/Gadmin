<?php

/**
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/07
 * @Copyright: blog.ghostry.cn
 */

namespace Home\Controller;

use Think\Controller;

class JobsController extends CommonController {

    public function __construct() {
        parent::__construct();
        function_exists('set_time_limit') && set_time_limit(0); //防止超时
        ignore_user_abort(true); //断开后仍然执行完成
    }

    /**
     * 清理缓存
     */
    public function cache($aa) {
        if ($aa == 'y3upy3edy') {
            delDirAndFile(RUNTIME_PATH, TRUE);
            if (!is_dir(RUNTIME_PATH . 'Cache')) {
                //D('System')->log('清除缓存');
                //$this->success('清除成功！');
                exit('ok');
            } else {
                //$this->error('清除失败！');
                exit;
            }
        }
    }

    /**
     * 删除无用文件,整理后可用
     */
    public function rmuploadimg($dir = '', $aa = '') {
        if ($aa != 'y3upy3edy') {
            exit;
        }
        exit;
        ob_implicit_flush(true);
        //print str_repeat(" ", 4096);
        if ($dir == '') {
            $dir = rtrim(UPLOAD_PATH, '/');
            echo "<script type='text/javascript'>
function up()
{
scrollTo(0,document.body.scrollHeight);
}
var s=setInterval('up()',1000);
</script> ";
            $this->n = 1;
            //echo "<br /><br />\n";
        }
        $folder = opendir($dir);
        while ($f = readdir($folder)) {
            if ($f <> "." && $f <> "..") {
                $f = $dir . '/' . $f;
                if (is_dir($f)) {
                    $this->rmuploadimg($f, $aa);
                } else {
                    //检查代理表
                    $s = D('Agent')->findfile('/' . $f);
                    if ($s > 0) {
                        echo '/' . $f . "有效<br /><br />\n";
                    } else {
                        //检查系统表
                        $s = D('System')->findfile('/' . $f);
                        if ($s > 0) {
                            echo '/' . $f . "有效<br /><br />\n";
                        } else {
                            //检查单页表
                            $s = D('Page')->findfile('/' . $f);
                            if ($s > 0) {
                                echo '/' . $f . "有效<br /><br />\n";
                            } else {
                                //检查手册表
                                $s = D('Manual')->findfile('/' . $f);
                                if ($s > 0) {
                                    echo '/' . $f . "有效<br /><br />\n";
                                } else {
                                    unlink($f);
                                    echo $this->n . ' : ' . '/' . $f . "已删除<br /><br />\n";
                                    $this->n ++;
                                }
                            }
                        }
                    }
                }
                //ob_flush();
                //flush();
                //sleep(1);
                //if ($n % 1000 == 0) {
                //echo "<script type='text/javascript'> up() ;</script>";
                // exit;
                //}
            }
        }
        if ($dir == rtrim(UPLOAD_PATH, '/')) {
            echo "一共删除" . $this->n . "个无效文件";
            echo "<br /><br />\n";
            //sleep(2);
            echo "<script type='text/javascript'> clearInterval(s) ;</script>";
        }
    }

    /**
      +----------------------------------------------------------
     * 备份数据库，整理后可用
      +----------------------------------------------------------
     */
    public function backsql($aa) {
        if ($aa != 'y3upy3edy') {
            exit;
        }
        $path = DATABASE_PATH . date('Ym') . '/';
        makeDir($path);
        $filename = date('d') . '.sql';
        //header("Content-Type: application/vnd.sql; charset=utf8");
        //header("Content-Disposition: attachment; filename=$filename");
        $M = M();
        $type = "自动备份";
        $tables = D("System")->getAllTableName(); //读取所有表
        //要备份数据的表
        $backedTable = array(
            '' . MYSQL_DB_PREFIX . 'admin',
            '' . MYSQL_DB_PREFIX . 'admin_role',
            '' . MYSQL_DB_PREFIX . 'city',
            '' . MYSQL_DB_PREFIX . 'district',
            '' . MYSQL_DB_PREFIX . 'jobs',
            '' . MYSQL_DB_PREFIX . 'menu',
            '' . MYSQL_DB_PREFIX . 'news',
            '' . MYSQL_DB_PREFIX . 'page',
            '' . MYSQL_DB_PREFIX . 'province',
            '' . MYSQL_DB_PREFIX . 'system',
        );
        $myfile = fopen($path . $filename, "w") or die("Unable to open file!");
        $str = "-- -----------------------------------------------------------\n" .
                "-- Database backup files\n" .
                "-- Blog: http://blog.ghostry.cn\n" .
                "-- Type: {$type}\n" .
                "-- Description:\n" .
                "-- ----当前SQL文件包含了表：" . implode("、", $tables) . "的结构信息，\n" .
                "-- ----表：" . implode("、", $backedTable) . "的数据" .
                "\n-- Time: " . date("Y-m-d H:i:s") . "\n" .
                "-- -----------------------------------------------------------\n\n\n\n";
        $str.= D("System")->bakupTable($tables) . "\n"; //取得表结构信息
        fwrite($myfile, $str);
        foreach ($backedTable as $table) {
            $str = "\n-- 数据库表：{$table} 数据信息\n";
            fwrite($myfile, $str);
            $tableInfo = $M->query("SHOW TABLE STATUS LIKE '{$table}'");
            $pagesize = 100;
            $page = ceil($tableInfo[0]['Rows'] / $pagesize) - 1;
            for ($i = 0; $i <= $page; $i++) {
                $query = $M->query("SELECT * FROM {$table} LIMIT " . ($i * $pagesize) . ", $pagesize");
                $str = "";
                foreach ($query as $val) {
                    $tn = 0;
                    $temSql = '';
                    foreach ($val as $v) {
                        $v = str_replace("'", '&#039;', $v);
                        $v = str_replace("\\", '&bsol;', $v);
                        $temSql.=$tn == 0 ? "" : ",";
                        $temSql.=$v == '' ? "''" : "'{$v}'";
                        $tn++;
                    }
                    $str .= "INSERT INTO `{$table}` VALUES ({$temSql});\n";
                }
                fwrite($myfile, $str);
            }
        }
        $str = "\n\n-- Time: " . date("Y-m-d H:i:s") . "\n";
        fwrite($myfile, $str);
        fclose($myfile);
        //压缩文件
        if (D("System")->zip(array($filename), $filename . '.zip', $path, $path)) {
            unlink($path . $filename);
        }
        echo 'ok';
    }

    /**
     * 删除过期备份
     */
    public function rmback($aa) {
        if ($aa != 'y3upy3edy') {
            exit;
        }
        $dir = DATABASE_PATH;
        $folder = opendir($dir);
        while ($f = readdir($folder)) {
            if ($f <> "." && $f <> ".." && $f <> ".htaccess") {
                $date = $f;
                $f = $dir . $f;
                if (is_dir($f)) {
                    if ($date < date('Ym')) {
                        delDirAndFile($f, 1);
                    } else {
                        $fo = opendir($f);
                        while ($ff = readdir($fo)) {
                            if ($ff <> "." && $ff <> ".." && $ff <> ".htaccess") {
                                if (substr($date . $ff, 0, -4) < date('Ymd', strtotime('-7day'))) {
                                    unlink($f . '/' . $ff);
                                }
                            }
                        }
                    }
                }
            }
        }
        echo 'ok';
    }

}
