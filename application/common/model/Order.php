<?php
namespace app\common\model;

use think\Model;

class Order extends Model
{
    protected $autoWriteTimestamp = true;

    public function add($data) {
        $orderId = $this->insertGetId($data);
        return $orderId;
    }
}