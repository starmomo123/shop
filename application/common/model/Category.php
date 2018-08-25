<?php
namespace app\common\model;

use think\Model;

class Category extends Model
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

        //保存数据操作
        if($this->save($data)) {
            return true;
        }else {
            return false;
        }
    }

    //获取所有的一级分类
    public function getAllCategory(&$category, $parent_id = 0) {
        $condition = [
            ['parent_id', '=', $parent_id],
        ];

        $order = [
            'id' => 'desc',
            'listorder' => 'asc'
        ];

        $category = $this->where($condition)
            ->order($order)
            ->paginate();
        if($category == false) {
            return false;
        }else {
            return true;
        }
    }

    //获取正常的分类列表
    public function getNormalFirstCategory(&$category, $parent_id = 0) {
        $condition = [
            ['parent_id', '=', $parent_id],
            ['status', 'in', '0,1']
        ];

        $order = [
            'id' => 'desc',
            'listorder' => 'asc'
        ];

        $category = $this->where($condition)
             ->order($order)
             ->select();
        if($category == false) {
            return false;
        }else {
            return true;
        }
    }

}