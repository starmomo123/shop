<?php
namespace app\common\model;

use think\Model;

class BisAccount extends Model
{
    protected $autoWriteTimestamp = true;

    public function add($data) {
        $data['listorder'] = 10;
        $data['status'] = 0;

        $ret = $this->save($data);
        if($ret) {
            return true;
        }else {
            return false;
        }
    }

    public function getBisAccount($bis_id, &$bisAccount) {
        $condition = [
            'bis_id' => $bis_id,
            'status' => ['>=', 0]
        ];

        $order = ['id' => 'asc'];

        $bisAccount = $this->where($condition)
            ->order($order)
            ->select();
        if($bisAccount == false) {
            return false;
        }else {
            return true;
        }
    }
}