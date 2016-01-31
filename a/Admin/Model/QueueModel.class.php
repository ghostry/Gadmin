<?php

/**
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2015/09
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Model;

use Think\Model;

class QueueModel extends CommonModel {

    protected $tablenameCN = '队列';

    /**
     * 添加
     */
    public function a($url, $ok, $post = '', $you = 0) {
        $data['url'] = $url;
        $data['ok'] = $ok;
        $data['post'] = $post ? serialize($post) : '';
        $data['you'] = $you;
        $data['admin'] = $this->returnAdmin();
        return $this->data($data)->add();
    }

    /**
     * 执行
     */
    public function run() {
        $where['ret'] = '';
        $r = $this->where($where)->order('you desc,id')->find();
        if (!$r) {
            $where['ret'] = array('neq', '');
            $r = $this->where($where)->find();
            if ($r) {
                $this->where($where)->setField('ret', '');
            } else {
                $this->execute('truncate table  `' . MYSQL_DB_PREFIX . 'queue`');
                exit('ok');
            }
        }
        //检查是否正在进行
        $huancunname = 'Queuerun' . $r['id'];
        if (S($huancunname)) {
            exit('ok');
        }
        S(array('expire' => 3600));
        S($huancunname, 1);
        $ok = http($r['url'], $r['post'] ? unserialize($r['post']) : '', 'POST');
//        echo $r['url'] . '<br />';
//        var_export(unserialize($r['post']));
//        echo '<br />';
//        var_dump($ok);
//        echo '<br />';
        $del = ($ok == $r['ok']);
        //var_dump($del);
        if ($del) {
            $this->where($r)->delete();
        } else {
            $this->where($r)->data(array('ret' => $ok))->save();
        }
        S($huancunname, 0);
    }

}
