<?php

namespace Home\Controller;

use Think\Controller;

class PublicController extends Controller
{
    public function login()
    {
        $this->display('login');
    }

    public function doLogin()
    {
        $request = I('post.login_data');
        $userMdl = D('user');
        $loginRes = $userMdl->doLogin($request);
        if ($loginRes) {
            $this->success('登录成功', U('Index/index'));
        } else {
            $this->error('登录失败，请重试');
        }
    }

    public function loginOut()
    {
        session('UserData', null);
        $this->redirect('Public/login');
    }

    public function register()
    {
        $this->display('register');
    }
}