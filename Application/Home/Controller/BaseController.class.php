<?php

namespace Home\Controller;

use Think\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // 判断用户登录
        if (!session('UserData')) {
            $this->redirect('Public/login');
        }
    }
}