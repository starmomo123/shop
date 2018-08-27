<?php
namespace app\common\model;

use think\Model;

class BisLocation extends Model
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

    public function getBisLocation($bis_id, &$bisLocation) {
        $condition = [
            'bis_id' => $bis_id,
            'status' => ['>=', 0]
        ];

        $order = ['id' => 'asc'];

        $bisLocation = $this->where($condition)
                            ->order($order)
                            ->field(['id', 'name', 'logo', 'is_main', 'status', 'create_time'])
                            ->select();
        if($bisLocation == false) {
            return false;
        }else {
            return true;
        }
    }
}