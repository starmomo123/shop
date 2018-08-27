<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Category extends Controller
{
    private $model;  //模型实例
    private $validate; //验证实例

    public function initialize() {
        $this->model = model('category');
        $this->validate = validate('category');
    }

    public function index()
    {
        $parent_id = input('get.parent_id', 0, 'intval');
        $cagetory = [];
        $this->model->getAllCategory($cagetory, $parent_id);
        return $this->fetch('', compact('cagetory'));
    }

    public function add(Request $request) {
        if($request->isPost()) {
            $data = input('post.');
            //数据验证
            if(!$this->validate->scene('add')->check($data)) {
                $this->error($this->validate->getError());
            }
            //数据入库
            $ret = $this->model->add($data);
            if($ret) {
                $this->success('新增分类成功');
            }else {
                $this->error('新增分类失败');
            }
        }else {
            $category = [];
            $this->model->getNormalFirstCategory($category);
            return $this->fetch('', compact('category'));
        }
    }

    public function edit($id) {
        if(request()->isPost()) {
            $data = input('post.');
            if(!$this->validate->scene('add')->check($data)) {
                $this->error($this->validate->getError());
            }
            $ret = $this->model->save($data, ['id' => intval($data['id'])]);
            if($ret) {
                $this->success('修改分类成功');
            }else {
                $this->error('修改分类失败');
            }
        }else {
            if(!$this->validate->scene('edit')->check(['id' => $id])) {
                $this->error($this->validate->getError());
            }
            if($id < 0) {
                $this->error('id不合法');
            }
            $category = $this->model->get($id);
            $categorys = [];
            $this->model->getNormalFirstCategory($categorys);
            return $this->fetch('', compact('category', 'categorys'));
        }

    }

    public function delete($id) {
        if(!$this->validate->scene('edit')->check(['id' => $id])) {
            $this->error($this->validate->getError());
        }
        if($id < 0) {
            return $this->error('分类id不合法');
        }
        $category = $this->model->get($id);
        $ret = $category->delete();
        if($ret) {
            $this->success('删除成功');
        }else {
            $this->error('删除失败');
        }
    }
}
