<?php
namespace app\bis\controller;


class Index extends Controller
{
    public function index() {
        $username = $this->user['username'];
        return $this->fetch('', compact('username'));
    }

    public function welcome() {
        return '欢迎来到daniel开发的商家模块管理后台';
    }
}
