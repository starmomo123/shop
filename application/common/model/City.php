<?php

namespace app\common\model;

use think\Model;

class City extends Model
{
    //自动写入时间戳
    protected $autoWriteTimestamp = true;
    /**
     * 插入数据
     * @param array $data
     * @return bool|void
     */
    public function add($data) {
        $data['listorder'] = 10;
        $data['status'] = 0;
        $data['is_default'] = 0;

        //保存数据操作
        if($this->save($data)) {
            return true;
        }else {
            return false;
        }
    }

    //获取所有的一级分类
    public function getAllCity(&$city, $parent_id = 0) {
        $condition = [
            ['parent_id', '=', $parent_id],
        ];

        $order = [
            'listorder' => 'desc'
        ];

        $city = $this->where($condition)
            ->order($order)
            ->paginate();
        if($city == false) {
            return false;
        }else {
            return true;
        }
    }

    //获取正常的分类列表
    public function getNormalFirstCity(&$city, $parent_id = 0) {
        $condition = [
            ['parent_id', '=', $parent_id],
            ['status', 'in', '0,1']
        ];

        $order = [
            'listorder' => 'desc'
        ];

        $city = $this->where($condition)
            ->order($order)
            ->select();
        if($city == false) {
            return false;
        }else {
            return true;
        }
    }
}
