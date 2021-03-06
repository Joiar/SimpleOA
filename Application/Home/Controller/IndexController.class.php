<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        $noticeList = M('notice')->where(array('department_id' => session('UserData.department_id')))->select();
        $this->assign('notice_list', $noticeList);
        $count = array(
            'userCount' => D('user')->getCount(),
            'departmentCount' => D('department')->getCount(),
            'positionCount' => D('position')->getCount(),
            'approval' => D('approval')->getCount()
        );
        $this->assign('count', $count);
        $this->display('index');
    }
}