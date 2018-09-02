<?php

namespace app\bis\controller;

use think\Controller;
use think\Request;

class BisAccount extends Controller
{
    private $city;
    private $category;
    private $bis;
    private $bisLocation;
    private $bisAccount;
    protected function initialize() {
        $this->city = model('city');
        $this->category = model('category');
        $this->bis = model('bis');
        $this->bisLocation = model('BisLocation');
        $this->bisAccount = model('bis_account');
    }

    public function index() {
        $bisAccount = $this->bisAccount->get(session('bis_uid'));
        $bis_id = $bisAccount['bis_id'];
        $bisAccounts = [];
        $this->bisAccount->getBisAccount($bis_id, $bisAccounts);
        return $this->fetch('', compact('bisAccounts'));
    }

    public function add(Request $request) {
        if($request->isPost()) {
            $bisAccount = $this->bisAccount->get(session('bis_uid'));
            $bis_id = $bisAccount['bis_id'];
            $data = input('post.');
            $data['password'] = md5($data['password']);
            $data['bis_id'] = $bis_id;
            $data['is_main'] = 0;
            $ret = $this->bisAccount->add($data);
            if($ret) {
                $this->success('添加成功');
            }else {
                $this->error('添加失败');
            }
        }else {
            return $this->fetch();
        }
    }
}
