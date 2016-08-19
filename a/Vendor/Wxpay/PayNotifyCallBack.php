<?php

require_once 'WxPayNotify.php';

class PayNotifyCallBack extends WxPayNotify {

    //查询订单
    public function Queryorder($transaction_id) {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        if (array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg) {
        $notfiyOutput = array();
        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            \Think\Log::write($msg);
            return false;
        }
        //查询订单，判断订单真实性
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            \Think\Log::write($msg);
            return false;
        }
        //查询订单
        $where['wxdd'] = $data['out_trade_no'];
        $cart = D('ChanpinDingdan')->where($where)->find();
        //检查订单是否已支付
        if ($cart['yifu'] == 1) {
            $msg = "订单已支付";
            \Think\Log::write($msg);
            return true;
        }
        //检查订单金额是否相符
        if ($cart['num'] * $cart['amount'] * 100 != $data['total_fee']) {
            $msg = "订单金额不符";
            \Think\Log::write($msg);
            return false;
        }
        $cart['xpkz'] = unserialize($cart['xpkz']);
        $sdata['id'] = $cart['id'];
        $sdata['yifu'] = 1;
        $sdata['yishen'] = 1;
        $sdata['paytype'] = 1;
        $sdata['wxls'] = $data['transaction_id'];
        $sdata['wxtime'] = date('YmdHis');
        $sdata['admin'] = '微信';
        D('ChanpinDingdan')->startTrans();
        $ok = D('ChanpinDingdan')->data($sdata)->save();
        //减少库存
        unset($data);
        $data['type'] = 5;
        $data['kid'] = $cart['xpkz']['wid'];
        $zinfo = D('Zhuanpan')->where(array('id' => $data['kid'],))->find();
        $data['num'] = '-' . $cart['num'];
        $data['numed'] = $zinfo['kucun'] + $data['num'];
        $data['admin'] = '代理' . $cart['agentId'];
        $ok1 = D('Zhuanpan')->where(array('id' => $data['kid'],))->setField('kucun', $data['numed']);
        $ok2 = D('Kucun')->add($data);
        if (!$ok || !$ok1 || !$ok2) {
            D('ChanpinDingdan')->rollback();
            $msg = "付款失败，请重试";
            \Think\Log::write($msg);
            \Think\Log::write(var_export($data, 1));
            \Think\Log::write(var_export($sdata, 1));
            return false;
        } else {
            D('ChanpinDingdan')->commit();
            $msg = "付款成功";
            \Think\Log::write($msg);
            return true;
        }
    }

}
