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
        $departmentMdl = D('department');
        $department_list = $departmentMdl->getList();
        $this->assign('department_list', $department_list);
        $this->display('register');
    }

    public function doRegister()
    {
        $request = I('post.register_data');
        $userMdl = D('user');
        $isRegister = $userMdl->checkRegister($request['user_no']);
        if ($isRegister) {
            $this->error('该员工号已被注册');
            exit();
        }
        $regRes = $userMdl->saveNewUser($request);
        if ($regRes) {
            $this->success('注册成功', U('Public/register'));
        } else {
            $this->error('注册失败，请重试');
        }
    }

    public function getPositionList()
    {
        $department_id = I('post.department_id');
        $positionMdl = D('position');
        $map = array(
            'department_id' => $department_id
        );
        $positionList = $positionMdl->where($map)->select();
        if ($positionList) {
            $res = array(
                'status' => 1,
                'msg' => '查询职位列表成功',
                'data' => $positionList
            );
        } else {
            $res = array(
                'status' => 0,
                'msg' => '该部门下暂无职位',
                'data' => array()
            );
        }
        $this->ajaxReturn($res);
    }
}