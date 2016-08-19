<?php

/**
 * 短信宝SDK for thinkPHP 3.2
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/11
 * @Copyright: blog.ghostry.cn
 */

namespace Lib;

class Sms {

    private $statusStr;
    private $smsapi;
    private $user;
    private $pass;
    public $error;
    public $sign;

    public function __construct($user, $pass, $sign = '') {

        $this->statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词",
            "51" => "手机号码不正确",
        );
        $this->smsapi = "http://www.smsbao.com/"; //短信网关
        $this->user = $user; //短信平台帐号
        $this->pass = md5($pass); //短信平台密码
        $this->sign = $sign; //签名
    }

    /**
     * 发送短信。群发使用数组，例array('137********','136********')
     * @param String or Array $phone 手机号
     * @param String $content 短信内容
     * @return Boolean
     */
    public function send($phone, $content) {
        if (!$phone || !$content) {
            $this->error = '手机号或内容为空';
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
        $content = $this->sign ? "【" . $this->sign . "】" . $content : $content;
        $sendurl = $this->smsapi . "sms?u=" . $this->user . "&p=" . $this->pass . "&m=" . $phone . "&c=" . urlencode($content);
        $result = file_get_contents($sendurl);
        $this->error = $this->statusStr[$result];
        if ($result == 0) {
            //统计发信数量
            $where['name'] = 'faxin' . date('Ymd');
            $where['num'] = M('Counter')->where($where)->getField('num');
            $where['num'] ++;
            M('Counter')->add($where, array(), 1);
        }
        //记录短信发送
        $data['phone'] = $phone;
        $data['text'] = $content;
        $data['ret'] = $result;
        M('Duanxinlog')->data($data)->add();
        return $result == 0;
    }

    /**
     * 查看剩余量 $return[0] 是余额， $return[1] 是短信余量
     * @return Boolean or Array
     */
    public function status() {
        $sendurl = $this->smsapi . "query?u=" . $this->user . "&p=" . $this->pass;
        $result = file_get_contents($sendurl);
        $this->error = $result;
        $result = explode("\n", $result);
        if ($result[0] == 0) {
            $result[1] = explode(',', $result[1]);
            return $result[1];
        } else {
            return FALSE;
        }
    }

}
