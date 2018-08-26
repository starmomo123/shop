<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

class Category extends Controller
{
    private $category;
    private $code = 100;
    private $msg = '';
    public function initialize()
    {
        $this->category = model('category');
    }

    public function getSecondCategory() {
        $categoryId = input('get.categoryId');
        if($categoryId < 0) {
            $this->code = 101;
            $this->msg = '分类ID不合法';
            return $this->ajaxReturn();
        }
        $category = [];
        $this->category->getNormalFirstCategory($category, $categoryId);
        return $this->ajaxReturn($category);
    }

    public function ajaxReturn($data = []) {
        return json_encode([
            'code' => $this->code,
            'data' => $data,
            'msg' => $this->msg
        ]);
    }
}
