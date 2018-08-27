<?php
namespace app\common\model;

use think\Model;

class Bis extends Model
{
    protected $autoWriteTimestamp = true;

    public function add($data, &$bis_id) {
        $data['listorder'] = 10;
        $data['status'] = 0;
        $data['money'] = 1500000;

        $bis_id = $this->insertGetId($data);
        if($bis_id) {
            return true;
        }else {
            return false;
        }
    }
}