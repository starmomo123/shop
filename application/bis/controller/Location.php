<?php
namespace app\bis\controller;


use think\Request;

class Location extends Controller
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
        $this->bisAccount = model('BisAccount');
    }
    public function index() {
        $bisAccount = $this->bisAccount->get(session('bis_uid'));
        $bis_id = $bisAccount['bis_id'];
        $bisLocation = [];
        $ret = $this->bisLocation->getBisLocation($bis_id, $bisLocation);
        if(!$ret) {
            $this->error('获取门店失败!~~');
        }

        return $this->fetch('', compact('bisLocation'));
    }

    public function add(Request $request) {
        if($request->isPost()) {
            $data = input('post.');

            //不做数据的验证

            $bisAccount = $this->bisAccount->get(session('bis_uid'));
            $bis_id = $bisAccount['bis_id'];
            //门店信息
            $bis_location['bis_id'] = $bis_id;
            $bis_location['tel'] = $data['tel'];
            $bis_location['logo'] = $data['logo'];
            $bis_location['contact'] = $data['contact'];
            //商户名称
            $bis_location['name'] = $data['name'];
            //是否是总店
            $bis_location['is_main'] = 0;
            $bis_location['city_id'] = $data['city_id'];
            $bis_location['city_path'] = $data['city_id'].','.$data['se_city_id'];
            $bis_location['category_id'] = $data['category_id'];
            $bis_location['category_path'] = $data['category_id'].','.$data['se_category_id'];
            $bis_location['address'] = $data['address'];
            $bis_location['api_address'] = $data['address'];
            //根据地理位置获取经纬度
            $ret = \Map::getLngLat($data['address']);
            if(!$ret) {
                $this->error('该地理位置不存在');
            }
            $bis_location['xpoint'] = $ret['lat'];
            $bis_location['ypoint'] = $ret['lng'];
            $bis_location['open_time'] = $data['open_time'];
            $bis_location['content'] = $data['content'];
            $ret = $this->bisLocation->add($bis_location);
            if(!$ret) {
                $this->error('新增门店失败');
            }
            $this->success('新增门店成功');
        }else {
            $citys = [];
            $categorys = [];
            $this->city->getNormalFirstCity($citys);
            $this->category->getNormalFirstCategory($categorys);
            return $this->fetch('', compact('citys', 'categorys'));
        }
    }
}
