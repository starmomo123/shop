<?php

namespace app\bis\controller;

use think\Request;

class Deal extends Controller
{
    private $city;
    private $category;
    private $bis;
    private $bisLocation;
    private $bisAccount;
    private $deal;
    protected function initialize() {
        $this->city = model('city');
        $this->category = model('category');
        $this->bis = model('bis');
        $this->bisLocation = model('BisLocation');
        $this->bisAccount = model('BisAccount');
        $this->deal = model('deal');
    }
    public function index() {
        $bisAccount = $this->bisAccount->get(session('bis_uid'));
        $bis_id = $bisAccount['bis_id'];
        $bisLocation = [];
        $this->bisLocation->getBisLocation($bis_id, $bisLocation);
        $deal = [];
        $this->deal->getDeal($bis_id, $deal);
        foreach ($deal as $k => $item) {
            $location = '';
            $location_ids = explode(',', $item['location_ids']);
            foreach ($location_ids as $v) {
                foreach ($bisLocation as $vv) {
                    if($v == $vv['id']) {
                        $location .= $vv['name'].';';
                    }
                }
            }
            $deal[$k]['location'] = substr($location, 0, strlen($location)-1);
        }
        return $this->fetch('', compact('deal'));
    }

    public function add(Request $request) {
        if($request->isPost()) {
            $data = input('post.');

            //不做数据的验证
            $bisAccount = $this->bisAccount->get(session('bis_uid'));
            $bis_id = $bisAccount['bis_id'];
            $deal['bis_id'] = $bis_id;
            $deal['name'] = $data['name'];
            $deal['location_ids'] = implode(',', $data['location_ids']);
            $deal['category_id'] = $data['category_id'];
            $deal['se_category_id'] = $data['category_id'].','.$data['se_category_id'];
            $deal['image'] = $data['image'];
            $deal['start_time'] = $data['start_time'];
            $deal['end_time'] = $data['end_time'];
            $deal['total_count'] = $data['total_count'];
            $deal['origin_price'] = $data['origin_price'];
            $deal['current_price'] = $data['current_price'];
            $deal['coupons_begin_time'] = $data['coupons_begin_time'];
            $deal['coupons_end_time'] = $data['coupons_end_time'];
            $deal['description'] = $data['description'];
            $deal['notes'] = $data['notes'];
            $ret = $this->deal->add($deal);
            if (!$ret) {
                $this->error('新增团购商品失败');
            }
            $this->success('新增团购商品成功');
        }else {
            $citys = [];
            $categorys = [];
            $bisLocation = [];
            $bisAccount = $this->bisAccount->get(session('bis_uid'));
            $bis_id = $bisAccount['bis_id'];
            $this->city->getNormalFirstCity($citys);
            $this->category->getNormalFirstCategory($categorys);
            $ret = $this->bisLocation->getBisLocation($bis_id, $bisLocation);
            if(!$ret) {
                $this->error('获取门店失败!~~');
            }
            return $this->fetch('', compact('citys', 'categorys', 'bisLocation'));
        }
    }
}
