<?php
namespace app\common\model;

use think\Model;

class Deal extends Model
{
    protected $autoWriteTimestamp = true;

    public function add($data) {
        $data['listorder'] = 10;
        $data['status'] = 0;
        //消费卷数量
        $data['buy_count'] = 100;

        $ret = $this->save($data);
        if($ret) {
            return true;
        }else {
            return false;
        }
    }

    public function getDeal($bis_id, &$deal) {
        $condition = [
            'bis_id' => $bis_id,
            'status' => ['>=', 0]
        ];

        $order = ['id' => 'asc'];

        $deal = $this->where($condition)
            ->order($order)
            ->select();
        if($deal == false) {
            return false;
        }else {
            return true;
        }
    }

    public function getAllDeal(&$deal) {
        $condition = [
            'status' => ['>=', 0]
        ];

        $order = ['id' => 'asc'];

        $deal = $this->where($condition)
            ->order($order)
            ->select();
        if($deal == false) {
            return false;
        }else {
            return true;
        }
    }
}