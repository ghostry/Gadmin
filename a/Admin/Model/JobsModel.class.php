<?php

/**
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/07
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Model;

use Think\Model;

class JobsModel extends CommonModel {

    protected $tablenameCN = '计划任务';
    protected $_auto = array(
        array('addtime', 'date', 1, 'callback'),
        array('admin', 'returnAdmin', 3, 'callback'),
    );

    /**
     *
     */
    public function run() {
        $where = '(`numed`<`num` or `num`=0)';
        $where .= " and (`year`='m' or `year`='" . date('Y') . "' )";
        $where.=" and (`month`='m' or `month`='" . (date('m') + 0) . "')";
        $where.=" and (`day`='m' or `day`='" . (date('d') + 0) . "')";
        $where.=" and (`hour`='m' or `hour`='" . (date('H') + 0) . "')";
        $where.=" and (`minute`='m' or `minute`='" . (date('i') + 0) . "')";
        $where.=" and (`week`='m' or `week`='" . (date('d') + 0) . "')";
        $list = $this->where($where)->select();
        foreach ($list as $value) {
            $ch = curl_init();
            $curl_opt = array(
                CURLOPT_URL => $value['url'],
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_TIMEOUT => 1,
            );
            curl_setopt_array($ch, $curl_opt);
            curl_exec($ch);
            curl_close($ch);
            //修改状态
            $this->where(array('id' => $value['id']))->setInc('numed');
        }
        //echo $this->_sql();
        //var_export($list);
    }

    /**
     *
     */
    public function date() {
        return date('YmdHis');
    }

    /**
     *
     */
    public function getWeek() {
        $r = array(
            'm' => '每天',
            1 => '星期一',
            2 => '星期二',
            3 => '星期三',
            4 => '星期四',
            5 => '星期五',
            6 => '星期六',
            7 => '星期日',
        );
        foreach ($r as $k => $v) {
            $arr[] = array($k, $v);
        }
        return $arr;
    }

    /**
     *
     */
    public function getMonth() {
        $r[] = array('m', '每月');
        for ($i = 1; $i <= 12; $i++) {
            $r[] = array($i, sprintf("%02d", $i));
        }
        return $r;
    }

    /**
     *
     */
    public function getDay($year = '', $month = '') {
        $r[] = array('m', '每天');
        if ($year && $month) {
            $tian = date('t', strtotime("$year-$month-01"));
            for ($i = 1; $i <= $tian; $i++) {
                $r[] = array($i, sprintf("%02d", $i));
            }
            return $r;
        } else {
            $tian = 31;
            for ($i = 1; $i <= $tian; $i++) {
                $r[] = array($i, sprintf("%02d", $i));
            }
            return $r;
        }
    }

    /**
     *
     */
    public function getHour() {
        $r[] = array('m', '每小时');
        for ($i = 0; $i <= 23; $i++) {
            $r[] = array($i + 1, sprintf("%02d", $i));
        }
        return $r;
    }

    /**
     *
     */
    public function getMinute() {
        $r[] = array('m', '每分钟');
        for ($i = 0; $i <= 59; $i++) {
            $r[] = array($i + 1, sprintf("%02d", $i));
        }
        return $r;
    }

}
