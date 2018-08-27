<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

class City extends Controller
{
    private $city;
    private $code = 100;
    private $msg = '';
    public function initialize()
    {
        $this->city = model('city');
    }

    public function getSecondCity() {
        $cityId = input('get.cityId');
        if($cityId < 0) {
            $this->code = 101;
            $this->msg = '城市ID不合法';
            return $this->ajaxReturn();
        }
        $city = [];
        $this->city->getNormalFirstCity($city, $cityId);
        return $this->ajaxReturn($city);
    }

    public function ajaxReturn($data = []) {
        return json_encode([
            'code' => $this->code,
            'data' => $data,
            'msg' => $this->msg
        ]);
    }
}
