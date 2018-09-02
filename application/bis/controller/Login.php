<?php
namespace app\bis\controller;

use think\Controller;
use think\Request;

class Login extends Controller
{
    private $bisValidate;
    private $city;
    private $category;
    private $bis;
    private $bisLocation;
    private $bisAccount;
    protected function initialize() {
        $this->bisValidate = validate('Bis');
        $this->city = model('city');
        $this->category = model('category');
        $this->bis = model('bis');
        $this->bisLocation = model('BisLocation');
        $this->bisAccount = model('bis_account');
    }
    public function index(Request $request) {
        $uid = session('bis_uid');
        if($uid) {
            $this->redirect(url('bis/index/index'));
        }
        if($request->isPost()) {
            $data = input('post.');
            if(!$this->bisValidate->scene('bis_account')->check($data)) {
                $this->error($this->bisValidate->getError());
            }
            $bisAccount = $this->bisAccount->get(['username' => $data['username']]);
            if(empty($bisAccount)) {
                $this->error('该商户不存在');
            }
            if(md5($data['password']) != $bisAccount['password']) {
                $this->error('密码不正确');
            }
            $last_login_ip = $request->ip();
            $last_login_time = time();
            $loginInfo = [
                'last_login_ip' => $last_login_ip,
                'last_login_time' => $last_login_time
            ];
            $this->bisAccount->save($loginInfo, ['id' => $bisAccount['id']]);
            session('bis_uid', $bisAccount['id']);
            cookie('isLogin', 1);
            $this->success('登录成功', url('bis/index/index'));

        }else {
            return $this->fetch();
        }
    }

    public function register(Request $request) {
        if($request->isPost()) {
            $data = input('post.');
            //商户基本信息
            $bis['name'] = $data['name'];
            $bis['city_id'] = $data['city_id'];
            $bis['city_path'] = $data['city_id'].','.$data['se_city_id'];
            $bis['logo'] = $data['logo'];
            $bis['licence_logo'] = $data['licence_logo'];
            $bis['description'] = $data['description'];
            $bis['bank_info'] = $data['bank_info'];
            $bis['bank_name'] = $data['bank_name'];
            $bis['bank_user'] = $data['bank_user'];
            $bis['faren'] = $data['faren'];
            $bis['faren_tel'] = $data['faren_tel'];
            $bis['email'] = $data['email'];
            if(!$this->bisValidate->scene('bis')->check($data)) {
                $this->error($this->bisValidate->getError());
            }
            $bis_id = 0;
            $ret = $this->bis->add($bis, $bis_id);
            if(!$ret) {
                $this->error('新增商户失败');
            }

            //总店信息
            $bis_location['bis_id'] = $bis_id;
            $bis_location['tel'] = $data['tel'];
            $bis_location['logo'] = $data['logo'];
            $bis_location['contact'] = $data['contact'];
            //商户名称
            $bis_location['name'] = $data['name'];
            //账户
            $bis_location['bank_info'] = $data['bank_info'];
            //是否是总店
            $bis_location['is_main'] = 1;
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
                $this->error('新增总店失败');
            }

            //商户账号信息
            $bis_account['bis_id'] = $bis_id;
            $bis_account['username'] = $data['username'];
            $bis_account['password'] = md5($data['password']);
            //是否是超级管理员
            $bis_account['is_main'] = 1;
            $ret = $this->bisAccount->add($bis_account);
            if(!$ret) {
                $this->error('新增管理员失败');
            }
            $this->success('新增成功');
        }else {
            $city = [];
            $category = [];
            $this->city->getNormalFirstCity($city);
            $this->category->getNormalFirstCategory($category);
            return $this->fetch('', compact('city', 'category'));
        }
    }

    public function logout() {
        session('bis_uid',null);
        cookie('isLogin', null);
        return redirect('bis/login/index');
    }
}