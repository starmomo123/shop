<?php
namespace app\common\model;

use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;

    public function add($data) {
        $data['status'] = 0;
        $data['listorder'] = 10;
        $ret = $this->save($data);
        if($ret) {
            return true;
        }else {
            return false;
        }
    }
}