<?php
namespace app\index\controller;

use think\Controller;
use think\Request;

class Login extends Controller
{
    private $user;

    protected function initialize()
    {
        $this->user = model('user');
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function login(Request $request)
    {
        if($request->isPost()) {
            $data = input('post.');
            //不做数据的验证
            $refer = $data['refer'];
            if ($refer == '') {
                $refer = url();
            }
            $user['username'] = $data['username'];
            $ret = $this->user->get(['username' => $data['username']]);
            if (empty($ret)) {
                $this->error('用户名不存在！！！');
            }
            $user['password'] = md5($data['password'].$ret['code']);
            if ($ret['password'] !== $user['password']) {
                $this->error('密码不正确');
            }

            $updateData = [
                'last_login_ip' => $request->ip(),
                'last_login_time' => time()
            ];

            $this->user->save($updateData, ['id' => $ret['id']]);
            session('uid', $ret['id']);
            cookie('isLogin', 1);
            return redirect($refer);

        }else {
            $refer = $request->server()['HTTP_REFERER'];
            return $this->fetch('login', compact('refer'));
        }
    }

    public function register(Request $request)
    {
        if($request->isPost()) {
            $data = input('post.');
            //不做数据的验证

            $user['username'] = $data['username'];
            $ret = $this->user->get(['username' => $data['username']]);
            if (!empty($ret)) {
                $this->error('用户名已经存在！！！');
            }
            $user['code'] = 'xing';
            $user['password'] = md5($data['password'].'xing');
            $user['email'] = $data['email'];
            $user['mobile'] = $data['mobile'];

            $ret = $this->user->add($user);
            if (!$ret) {
                $this->error('注册失败');
            }
            $this->success('注册成功', url('index/login/login'));
        }else {
            return $this->fetch('register');
        }
    }
}
