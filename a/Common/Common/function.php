<?php

/**
  +-----------------------------------------------------------------------------------------
 * 删除目录及目录下所有文件或删除指定文件
  +-----------------------------------------------------------------------------------------
 * @param str $path   待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
  +-----------------------------------------------------------------------------------------
 * @return bool 返回删除状态
  +-----------------------------------------------------------------------------------------
 */
function delDirAndFile($path, $delDir = FALSE) {
    $handle = is_dir($path) ? opendir($path) : 0;
    if ($handle) {
        while (false !== ( $item = readdir($handle) )) {
            if ($item != "." && $item != "..")
                is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
        }
        closedir($handle);
        if ($delDir)
            return rmdir($path);
    }else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return FALSE;
        }
    }
}

/**
  +----------------------------------------------------------
 * 功能：检测一个目录是否存在，不存在则创建它
  +----------------------------------------------------------
 * @param string    $path      待检测的目录
  +----------------------------------------------------------
 * @return boolean
  +----------------------------------------------------------
 */
function makeDir($path) {
    return is_dir($path) or ( makeDir(dirname($path)) and @ mkdir($path, 0777));
}

/**
 * 生成随机字符
 */
function getRandChar($length) {
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str.=$strPol[rand(0, $max)]; //rand($min,$max)生成介于min和max两个数之间的一个随机整数
    }

    return $str;
}

/**
 * 上传图片
 */
function _UPLOADPIC($upfile, $maxsize, $updir, $newname = 'date') {
    if ($newname == 'date')
        $newname = date("Ymdhis"); //使用日期做文件名
    $name = $upfile ["name"];
    $type = $upfile ["type"];
    $size = $upfile ["size"];
    $tmp_name = $upfile ["tmp_name"];

    switch ($type) {
        case 'image/pjpeg' :
        case 'image/jpeg' :
            $extend = ".jpg";
            break;
        case 'image/gif' :
            $extend = ".gif";
            break;
        case 'image/png' :
            $extend = ".png";
            break;
    }
    if (empty($extend)) {
        echo ( "警告！只能上传图片类型：GIF JPG PNG" );
        exit();
    }
    if ($size > $maxsize) {
        $maxpr = $maxsize / 1000;
        echo ( "警告！上传图片大小不能超过" . $maxpr . "K!" );
        exit();
    }
    if (move_uploaded_file($tmp_name, $updir . $newname . $extend)) {
        return $updir . $newname . $extend;
    }
}

/**
 * 计算宽高
 */
function show_pic_scal($width, $height, $picpath) {
    $imginfo = GetImageSize($picpath);
    $imgw = $imginfo [0];
    $imgh = $imginfo [1];

    $ra = number_format(($imgw / $imgh), 1); //宽高比
    $ra2 = number_format(($imgh / $imgw), 1); //高宽比


    if ($imgw > $width or $imgh > $height) {
        if ($imgw > $imgh) {
            $newWidth = $width;
            $newHeight = round($newWidth / $ra);
        } elseif ($imgw < $imgh) {
            $newHeight = $height;
            $newWidth = round($newHeight / $ra2);
        } else {
            $newWidth = $width;
            $newHeight = round($newWidth / $ra);
        }
    } else {
        $newHeight = $imgh;
        $newWidth = $imgw;
    }
    $newsize [0] = $newWidth;
    $newsize [1] = $newHeight;

    return $newsize;
}

/**
 * 获取图片信息
 */
function getImageInfo($src) {
    return getimagesize($src);
}

/**
 * 创建图片，返回资源类型
 * @param string $src 图片路径
 * @return resource $im 返回资源类型
 * * */
function create($src) {
    $info = getImageInfo($src);
    switch ($info[2]) {
        case 1:
            $im = imagecreatefromgif($src);
            break;
        case 2:
            $im = imagecreatefromjpeg($src);
            break;
        case 3:
            $im = imagecreatefrompng($src);
            break;
    }
    return $im;
}

/**
 * 缩略图主函数
 * @param string $src 图片路径
 * @param int $w 缩略图宽度
 * @param int $h 缩略图高度
 * @return mixed 返回缩略图路径
 * * */
function resize($src, $w, $h) {
    $temp = pathinfo($src);
    $name = $temp["basename"]; //文件名
    $dir = $temp["dirname"]; //文件所在的文件夹
    //$extension = $temp["extension"]; //文件扩展名
    $savepath = "{$dir}/{$name}.thumb.jpg"; //缩略图保存路径,新的文件名为*.thumb.jpg
    $quality = 60;
    //获取图片的基本信息
    $info = getImageInfo($src);
    $width = $info[0]; //获取图片宽度
    $height = $info[1]; //获取图片高度
    $per1 = round($width / $height, 2); //计算原图长宽比
    $per2 = round($w / $h, 2); //计算缩略图长宽比
    //计算缩放比例
    if ($per1 > $per2 || $per1 == $per2) {
        //原图长宽比大于或者等于缩略图长宽比，则按照宽度优先
        $per = $w / $width;
    }
    if ($per1 < $per2) {
        //原图长宽比小于缩略图长宽比，则按照高度优先
        $per = $h / $height;
    }
    $temp_w = intval($width * $per); //计算原图缩放后的宽度
    $temp_h = intval($height * $per); //计算原图缩放后的高度
    $temp_img = imagecreatetruecolor($temp_w, $temp_h); //创建画布
    $im = create($src);
    imagecopyresampled($temp_img, $im, 0, 0, 0, 0, $temp_w, $temp_h, $width, $height);
    if ($per1 > $per2) {
        imagejpeg($temp_img, $savepath, $quality);
        imagedestroy($im);
        return addBg($savepath, $w, $h, "w");
        //宽度优先，在缩放之后高度不足的情况下补上背景
    }
    if ($per1 == $per2) {
        imagejpeg($temp_img, $savepath, $quality);
        imagedestroy($im);
        return $savepath;
        //等比缩放
    }
    if ($per1 < $per2) {
        imagejpeg($temp_img, $savepath, $quality);
        imagedestroy($im);
        return addBg($savepath, $w, $h, "h");
        //高度优先，在缩放之后宽度不足的情况下补上背景
    }
}

/**
 * 添加背景
 * @param string $src 图片路径
 * @param int $w 背景图像宽度
 * @param int $h 背景图像高度
 * @param String $first 决定图像最终位置的，w 宽度优先 h 高度优先 wh:等比
 * @return 返回加上背景的图片
 * * */
function addBg($src, $w, $h, $fisrt = "w") {
    $bg = imagecreatetruecolor($w, $h);
    $white = imagecolorallocate($bg, 255, 255, 255);
    $quality = 60;
    imagefill($bg, 0, 0, $white); //填充背景
    //获取目标图片信息
    $info = getImageInfo($src);
    $width = $info[0]; //目标图片宽度
    $height = $info[1]; //目标图片高度
    $img = create($src);
    if ($fisrt == "wh") {
        //等比缩放
        return $src;
    } else {
        if ($fisrt == "w") {
            $x = 0;
            $y = ($h - $height) / 2; //垂直居中
        }
        if ($fisrt == "h") {
            $x = ($w - $width) / 2; //水平居中
            $y = 0;
        }
        imagecopymerge($bg, $img, $x, $y, 0, 0, $width, $height, 100);
        imagejpeg($bg, $src, $quality);
        imagedestroy($bg);
        imagedestroy($img);
        return $src;
    }
}

/**
 * 过滤html
 * @return String 过滤后字符串
 */
function safeHtml($str) {
    $str = htmlspecialchars_decode($str);
    $str = str_replace('"', '', $str);
    $str = preg_replace("@<script(.*?)</script>@is", "", $str);
    $str = preg_replace("@<iframe(.*?)</iframe>@is", "", $str);
    $str = preg_replace("@<style(.*?)</style>@is", "", $str);
    $str = preg_replace("@<(.*?)>@is", "", $str);
    $str = strip_tags($str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);
    return $str;
}

/**
 * 数字加逗号格式化
 * @param type $num
 * @return string|boolean
 */
function num_format($num) {
    if (!is_numeric($num)) {
        return false;
    }
    $rvalue = '';
    $num = explode('.', $num); //把整数和小数分开
    $rl = !isset($num['1']) ? '' : $num['1']; //小数部分的值
    $j = strlen($num[0]) % 3; //整数有多少位
    $sl = substr($num[0], 0, $j); //前面不满三位的数取出来
    $sr = substr($num[0], $j); //后面的满三位的数取出来
    $i = 0;
    while ($i <= strlen($sr)) {
        $rvalue = $rvalue . ',' . substr($sr, $i, 3); //三位三位取出再合并，按逗号隔开
        $i = $i + 3;
    }
    $rvalue = $sl . $rvalue;
    $rvalue = substr($rvalue, 0, strlen($rvalue) - 1); //去掉最后一个逗号
    $rvalue = explode(',', $rvalue); //分解成数组
    if ($rvalue[0] == 0) {
        array_shift($rvalue); //如果第一个元素为0，删除第一个元素
    }
    $rv = $rvalue[0]; //前面不满三位的数
    for ($i = 1; $i < count($rvalue); $i++) {
        $rv = $rv . ',' . $rvalue[$i];
    }
    if (!empty($rl)) {
        $rvalue = $rv . '.' . $rl; //小数不为空，整数和小数合并
    } else {
        $rvalue = $rv; //小数为空，只有整数
    }
    return $rvalue;
}
