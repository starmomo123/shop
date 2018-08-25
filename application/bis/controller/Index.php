<?php
namespace app\bis\controller;

use think\Controller;

class Index extends Controller
{
    public function index() {
        return $this->fetch();
    }

    public function welcome() {
        return '欢迎来到daniel开发的商家模块管理后台';
    }
}
