<?php
namespace app\bis\controller;

use think\Controller as BaseController;

class Controller extends BaseController
{
    protected $user=null;
    protected function initialize() {
        $this->getUser();
        if($this->user == null) {
            $this->error('请先登录', url('bis/login/index'));
        }
    }

    private function getUser() {
        if($this->user != null) {
            return ;
        }
        $model = model('BisAccount');
        $user = $model->get(session('bis_uid'));
        unset($user['password']);
        if($user == false) {
            $this->user = null;
        }else {
            $this->user = $user;
        }
        return $user;
    }
}
