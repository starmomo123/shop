<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function welcome() {
        return '欢迎来到daiel开发的主后台管理平台';
    }
}
