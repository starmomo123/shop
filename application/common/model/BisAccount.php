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
}