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
 * 生成随机数,
 * 1为数字，2为小写字母，4为大写字母。
 * 加法选择，如3（1+2）为数字加小写字母。
 * 默认为7
 */
function getRandChar($length = 6, $type = 0) {
    $str = null;
    switch ($type) {
        case 1:
            $strPol = "0123456789";
            break;
        case 2:
            $strPol = "abcdefghijklmnopqrstuvwxyz";
            break;
        case 3:
            $strPol = "0123456789abcdefghijklmnopqrstuvwxyz";
            break;
        case 4:
            $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            break;
        case 5:
            $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            break;
        case 6:
            $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            break;
        default:
            $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
            break;
    }
    $max = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str.=$strPol[rand(0, $max)]; //rand($min,$max)生成介于min和max两个数之间的一个随机整数
    }

    return $str;
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

/**
 * 多维数组根据指定键值排序
 * @param type $multi_array
 * @param type $sort_key
 * @param type $sort
 * @return boolean
 */
function multi_array_sort($multi_array, $sort_key, $sort = SORT_ASC) {
    if (is_array($multi_array)) {
        foreach ($multi_array as $row_array) {
            if (is_array($row_array)) {
                $key_array[] = $row_array[$sort_key];
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
    array_multisort($key_array, $sort, $multi_array);
    return $multi_array;
}

/* *
 * 支付宝接口公用函数
 * 详细：该类是请求、通知返回两个文件所调用的公用函数核心处理文件
 * 版本：3.3
 * 日期：2012-07-19
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstring($para) {
    $arg = "";
    while (list ($key, $val) = each($para)) {
        $arg.=$key . "=" . $val . "&";
    }
    //去掉最后一个&字符
    $arg = substr($arg, 0, count($arg) - 2);

    //如果存在转义字符，那么去掉转义
    if (get_magic_quotes_gpc()) {
        $arg = stripslashes($arg);
    }

    return $arg;
}

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstringUrlencode($para) {
    $arg = "";
    while (list ($key, $val) = each($para)) {
        $arg.=$key . "=" . urlencode($val) . "&";
    }
    //去掉最后一个&字符
    $arg = substr($arg, 0, count($arg) - 2);

    //如果存在转义字符，那么去掉转义
    if (get_magic_quotes_gpc()) {
        $arg = stripslashes($arg);
    }

    return $arg;
}

/**
 * 除去数组中的空值和签名参数
 * @param $para 签名参数组
 * return 去掉空值与签名参数后的新签名参数组
 */
function paraFilter($para) {
    $para_filter = array();
    while (list ($key, $val) = each($para)) {
        if ($key == "sign" || $key == "sign_type" || $val == "")
            continue;
        else
            $para_filter[$key] = $para[$key];
    }
    return $para_filter;
}

/**
 * 对数组排序
 * @param $para 排序前的数组
 * return 排序后的数组
 */
function argSort($para) {
    ksort($para);
    reset($para);
    return $para;
}

/**
 * 写日志，方便测试（看网站需求，也可以改成把记录存入数据库）
 * 注意：服务器需要开通fopen配置
 * @param $word 要写入日志里的文本内容 默认值：空值
 */
function logResult($word = '') {
//    $fp = fopen("log.txt", "a");
//    flock($fp, LOCK_EX);
//    fwrite($fp, "执行日期：" . strftime("%Y%m%d%H%M%S", time()) . "\n" . $word . "\n");
//    flock($fp, LOCK_UN);
//    fclose($fp);
    Think\Log::write("执行日期：" . strftime("%Y%m%d%H%M%S", time()) . "\n" . $word . "\n");
}

/**
 * 远程获取数据，POST模式
 * 注意：
 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
 * @param $url 指定URL完整路径地址
 * @param $cacert_url 指定当前工作目录绝对路径
 * @param $para 请求的数据
 * @param $input_charset 编码格式。默认值：空值
 * return 远程输出的数据
 */
function getHttpResponsePOST($url, $cacert_url, $para, $input_charset = '') {

    if (trim($input_charset) != '') {
        $url = $url . "_input_charset=" . $input_charset;
    }
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); //SSL证书认证
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); //严格认证
    curl_setopt($curl, CURLOPT_CAINFO, $cacert_url); //证书地址
    curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 显示输出结果
    curl_setopt($curl, CURLOPT_POST, true); // post传输数据
    curl_setopt($curl, CURLOPT_POSTFIELDS, $para); // post传输数据
    $responseText = curl_exec($curl);
    //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
    curl_close($curl);

    return $responseText;
}

/**
 * 远程获取数据，GET模式
 * 注意：
 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
 * @param $url 指定URL完整路径地址
 * @param $cacert_url 指定当前工作目录绝对路径
 * return 远程输出的数据
 */
function getHttpResponseGET($url, $cacert_url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 显示输出结果
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); //SSL证书认证
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); //严格认证
    curl_setopt($curl, CURLOPT_CAINFO, $cacert_url); //证书地址
    $responseText = curl_exec($curl);
    //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
    curl_close($curl);

    return $responseText;
}

/**
 * 实现多种字符编码方式
 * @param $input 需要编码的字符串
 * @param $_output_charset 输出的编码格式
 * @param $_input_charset 输入的编码格式
 * return 编码后的字符串
 */
function charsetEncode($input, $_output_charset, $_input_charset) {
    $output = "";
    if (!isset($_output_charset))
        $_output_charset = $_input_charset;
    if ($_input_charset == $_output_charset || $input == null) {
        $output = $input;
    } elseif (function_exists("mb_convert_encoding")) {
        $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
    } elseif (function_exists("iconv")) {
        $output = iconv($_input_charset, $_output_charset, $input);
    } else
        die("sorry, you have no libs support for charset change.");
    return $output;
}

/**
 * 实现多种字符解码方式
 * @param $input 需要解码的字符串
 * @param $_output_charset 输出的解码格式
 * @param $_input_charset 输入的解码格式
 * return 解码后的字符串
 */
function charsetDecode($input, $_input_charset, $_output_charset) {
    $output = "";
    if (!isset($_input_charset))
        $_input_charset = $_input_charset;
    if ($_input_charset == $_output_charset || $input == null) {
        $output = $input;
    } elseif (function_exists("mb_convert_encoding")) {
        $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
    } elseif (function_exists("iconv")) {
        $output = iconv($_input_charset, $_output_charset, $input);
    } else
        die("sorry, you have no libs support for charset changes.");
    return $output;
}

/* *
 * MD5
 * 详细：MD5加密
 * 版本：3.3
 * 日期：2012-07-19
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */

/**
 * 签名字符串
 * @param $prestr 需要签名的字符串
 * @param $key 私钥
 * return 签名结果
 */
function md5Sign($prestr, $key) {
    $prestr = $prestr . $key;
    return md5($prestr);
}

/**
 * 验证签名
 * @param $prestr 需要签名的字符串
 * @param $sign 签名结果
 * @param $key 私钥
 * return 签名结果
 */
function md5Verify($prestr, $sign, $key) {
    $prestr = $prestr . $key;
    $mysgin = md5($prestr);

    if ($mysgin == $sign) {
        return true;
    } else {
        return false;
    }
}

/**
 * 发送HTTP请求方法，目前只支持CURL发送请求
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function http($url, $params = array(), $method = 'GET', $header = array(), $multi = false, $timeout = 600) {
    $opts = array(
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER => $header,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36',
            // CURLOPT_REFERER=>'http://www.baidu.com/',
    );
    /* 根据请求类型设置特定参数 */
    switch (strtoupper($method)) {
        case 'GET':
            if ($params) {
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            } else {
                $opts[CURLOPT_URL] = $url;
            }
            //echo $opts[CURLOPT_URL];
            break;
        case 'POST':
//判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
//Log::write('ERROR:不支持的请求方式 ' . $method, 'httperror');
            return FALSE;
            return 'ERROR:不支持的请求方式 ' . $method;
//throw new Exception('不支持的请求方式！');
    }
//Log::write($opts[CURLOPT_URL], 'http');
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) {
        //echo $error;
        //Log::write('ERROR:请求发生错误：' . $error, 'httperror');
        return FALSE;
        return 'ERROR:请求发生错误：' . $error;
//throw new Exception('请求发生错误：' . $error);
    }
//Log::write($data, 'http');
    return $data;
}

/**
 * 秒转时间，格式 年 月 日 时 分 秒
 *
 * @author wangyupeng129@126.com
 * @param int $time
 * @return string|array|boolean
 */
function Sec2Time($time, $isarray = 0) {
    if (is_numeric($time)) {
        $value = array(
            "years" => 0, "days" => 0, "hours" => 0,
            "minutes" => 0, "seconds" => 0,
        );
        $str = '';
        if ($time >= 31556926) {
            $str.= $value["years"] = floor($time / 31556926);
            $time = ($time % 31556926);
            $str.='年';
        }
        if ($time >= 86400) {
            $str.=$value["days"] = floor($time / 86400);
            $time = ($time % 86400);
            $str.='天';
        }
        if ($time >= 3600) {
            $str.=$value["hours"] = floor($time / 3600);
            $time = ($time % 3600);
            $str.='时';
        }
        if ($time >= 60) {
            $str.=$value["minutes"] = floor($time / 60);
            $time = ($time % 60);
            $str.='分';
        }
        $str.=$value["seconds"] = floor($time);
        $str.='秒';
        return $isarray ? (array) $value : $str;
    } else {
        return (bool) FALSE;
    }
}

/**
 * 删除utf8特殊字符,例如🎉
 * @param type $str
 * @return type
 */
function removeByte4($str) {
    return preg_replace('/[\xF0-\xF7].../s', '', $str);
}

/**
 * 访客ip
 * @return type
 */
function get_real_ip() {
    $ip = false;
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
        for ($i = 0; $i < count($ips); $i++) {
            //if (!eregi ("^(10|172/.16|192/.168)/.", $ips[$i])) {
            if (!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

/**
 * 百度短网址
 */
function dwz($url) {
    $jieguo = (array) json_decode(http('http://dwz.cn/create.php', array('url' => $url), 'post'), 1);
    if ($jieguo['status'] == 0) {
        return $jieguo['tinyurl'];
    } else {
        //echo $jieguo['err_msg'];
        return 0;
    }
}

/**
 * 快速导入第三方框架类库 所有第三方框架的类库文件统一放到 程序的Vendor目录下面
 * @param string $class 类库
 * @param string $baseUrl 基础目录
 * @param string $ext 类库后缀
 * @return boolean
 */
function myVendor($class, $baseUrl = '', $ext = '.php') {
    if (empty($baseUrl))
        $baseUrl = MY_VENDOR_PATH;
    return import($class, $baseUrl, $ext);
}

/**
 * 阿里大鱼短信通知
 */
function sendsms($phone, $smstemplatecode, $data = '') {
    if (!$phone || !$smstemplatecode) {
        //$this->error = '手机号或短信模板为空';
        return FALSE;
    }
    //暂时关闭
    //return FALSE;
    if (is_array($phone)) {
        $phone = implode(',', $phone);
    }
    if (S('ph' . $phone) > time() - 300) {
        return false;
    }
    S('ph' . $phone, time());
    //http://open.taobao.com/doc2/apiDetail.htm?spm=0.0.0.0.J2tJSE&apiId=25450
    myVendor('alidayu.TopSdk');
    $c = new \TopClient();
    $c->appkey = DaYu_SMS_USER;
    $c->secretKey = DaYu_SMS_PASS;
    $c->format = 'json';
    //var_export($c);
    $req = new \AlibabaAliqinFcSmsNumSendRequest;
    //$req->setExtend("123456");//回传信息
    $req->setSmsType("normal");
    $req->setSmsFreeSignName(DaYu_SMS_SIGN); //发送的签名
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = (string) $value;
        }
    }
    $req->setSmsParam(is_array($data) ? json_encode($data) : $data); //根据模板进行填写
    $req->setRecNum($phone); //接收着的手机号码
    $req->setSmsTemplateCode($smstemplatecode);
    //var_export($req);
    $resp = $c->execute($req);
    //var_export($resp);
    //echo $resp->result->success;
    //echo $resp->result->err_code;
    $result = $resp->result->err_code;
    if ($result == 0) {
        //统计发信数量
        $where['name'] = 'dayufaxin' . date('Ymd');
        $where['num'] = M('Counter')->where($where)->getField('num');
        $where['num'] ++;
        M('Counter')->add($where, array(), 1);
    }
    //记录短信发送
    $data['phone'] = $phone;
    $data['text'] = $smstemplatecode . var_export($data, 1);
    $data['ret'] = var_export($resp, 1);
    M('Duanxinlog')->data($data)->add();
    return $result == 0;
}

/**
 * 阿里大鱼文本转语音通知
 */
function sendtts($phone, $smstemplatecode, $data = '') {
    if (!$phone || !$smstemplatecode) {
        $this->error = '手机号或短信模板为空';
        return FALSE;
    }
    //暂时关闭
    //return FALSE;
    if (is_array($phone)) {
        $phone = implode(',', $phone);
    }
    if (S('ph' . $phone) > time() - 300) {
        return false;
    }
    S('ph' . $phone, time());
    //http://open.taobao.com/doc2/apiDetail.htm?spm=0.0.0.0.l3vcfW&apiId=25444
    myVendor('alidayu.TopSdk');
    $c = new \TopClient();
    $c->appkey = DaYu_SMS_USER;
    $c->secretKey = DaYu_SMS_PASS;
    $c->format = 'json';
    $req = new \AlibabaAliqinFcTtsNumSinglecallRequest;
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = (string) $value;
        }
    }
    $req->setTtsParam(is_array($data) ? json_encode($data) : $data); //根据模板进行填写
    $req->setCalledNum($phone);
    $req->setCalledShowNum("4008221620");
    $req->setTtsCode($smstemplatecode);
    $resp = $c->execute($req);
    var_export($resp);
    //echo $resp->result->success;
    //echo $resp->result->err_code;
    $result = $resp->result->err_code;
    if ($result == 0) {
        //统计发信数量
        $where['name'] = 'dayuyuyin' . date('Ymd');
        $where['num'] = M('Counter')->where($where)->getField('num');
        $where['num'] ++;
        M('Counter')->add($where, array(), 1);
    }
    return $result == 0;
}

/**
 * 公历转农历
 * @param type $date
 * @return type
 */
function toLunar($date = '') {
    $lunar = new \Lib\Lunar();
    return $lunar->toLunar($date);
}

/**
 * 隐藏部分电话号码
 * @param type $phone
 * @return type
 */
function hidtel($phone) {
    $IsWhat = preg_match('/(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)/i', $phone); //固定电话
    if ($IsWhat == 1) {
        return preg_replace('/(0[0-9]{2,3}[\-]?[2-9])[0-9]{3,4}([0-9]{3}[\-]?[0-9]?)/i', '$1****$2', $phone);
    } else {
        return preg_replace('/(1[0-9]{1}[0-9])[0-9]{4}([0-9]{4})/i', '$1****$2', $phone);
    }
}

/**
 * get转select
 */
function get2select($arr) {
    foreach ($arr as $key => $value) {
        $r[] = array($key, $value);
    }
    return $r;
}

/*
 * 禁止页面缓存
 */

function nocache_headers() {
    @header('Expires: Thu, 01 Jan 1970 00:00:01 GMT');
    @header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    @header('Cache-Control: no-cache, must-revalidate, max-age=0');
    @header('Pragma: no-cache');
}

/*
 * 二维数组排序
 */

function multiArraySort($hotcat, $col, $sort = SORT_DESC) {
    //提取列数组；
    foreach ($hotcat as $key => $val) {
        $tmp[$key] = $val[$col];
    }
    array_multisort($tmp, $sort, $hotcat); //默认对数组进行降序排列；SORT_DESC按降序排列
    return $hotcat;
}

/**
 * 判断是否微信中打开
 * @return boolean
 */
function is_weixin() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }
    return false;
}
