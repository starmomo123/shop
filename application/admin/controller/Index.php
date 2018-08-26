<?php
namespace app\admin\controller;

use phpmailer\Mail;
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

    public function test() {
        $to = '3117748742@qq.com';
        $title = '今天天气很好';
        $content = '是的哈～～～～';
        $ret = Mail::send($to, $title, $content);
        return $ret;
    }
}
