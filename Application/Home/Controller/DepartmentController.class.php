<?php

namespace Home\Controller;

use Think\Controller;

class DepartmentController extends Controller
{

    public function showList()
    {
        $pageIndex = I('get.p') ? I('get.p') : 1;
        $departmentMdl = D('department');
        $department_list = $departmentMdl->getList(true, $pageIndex);
        $this->assign('department_list', $department_list);

        $count = $departmentMdl->getCount();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $Page->lastSuffix = false;//最后一页不显示为总页数
        $Page->setConfig('header','<li class="disabled hwh-page-info"</li>');
        $Page->setConfig('prev','«');
        $Page->setConfig('next','»');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $this->bootstrap_page_style($Page->show());
        $this->assign('page', $show);

        $this->display('index');
    }

    public function showMemberList()
    {
        $pageIndex = I('get.p') ? I('get.p') : 1;
        $userMdl = D('user');
        $userList = $userMdl->getList(true, $pageIndex, true);
        $this->assign('user_list', $userList);

        $count = $userMdl->getCount();
        $Page = new \Think\Page($count, C('PAGE_SIZE'));
        $Page->lastSuffix = false;//最后一页不显示为总页数
        $Page->setConfig('header','<li class="disabled hwh-page-info"</li>');
        $Page->setConfig('prev','«');
        $Page->setConfig('next','»');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $this->bootstrap_page_style($Page->show());
        $this->assign('page', $show);

        $this->display('memberlist');
    }

    /**
     * Thinkphp默认分页样式转Bootstrap分页样式
     * @author Carl
     * @param string $page_html tp默认输出的分页html代码
     * @return string 新的分页html代码
     */
    public function bootstrap_page_style($page_html){
        if ($page_html) {
            $page_show = str_replace('<div>','<nav><ul class="pagination pagination-sm no-margin pull-right">',$page_html);
            $page_show = str_replace('</div>','</ul></nav>',$page_show);
            $page_show = str_replace('<span class="current">','<li class="active"><a>',$page_show);
            $page_show = str_replace('</span>','</a></li>',$page_show);
            $page_show = str_replace(array('<a class="num"','<a class="prev"','<a class="next"','<a class="end"','<a class="first"'),'<li><a',$page_show);
            $page_show = str_replace('</a>','</a></li>',$page_show);
        }
        return $page_show;
    }

    public function add()
    {
        $department_name = I('post.department_name');
        $departmentMdl = D('department');
        $res = $departmentMdl->addDepartment($department_name);
        if ($res) {
            $this->redirect('Department/showList');
        } else {
            $this->error('添加失败，请重试');
        }
    }

    public function delete()
    {
        $department_id = I('post.department_id');
        $departmentMdl = D('department');
        $res = $departmentMdl->deleteDepartment($department_id);
        if ($res) {
            $this->ajaxReturn(array(
                'status' => 1,
                'msg' => '删除成功',
                'data' => array()
            ));
        } else {
            $this->ajaxReturn(array(
                'status' => 0,
                'msg' => '删除失败',
                'data' => array()
            ));
        }
    }

    public function setting()
    {
        $this->display('setting');
    }

    public function addNotice()
    {
        $this->display('addnotice');
    }

    public function doAddNotice()
    {
        $params = I('post.formdata');
        $params['department_id'] = session('UserData.department_id');
        $params['user_id'] = session('UserData.user_id');
        $params['created_at'] = time();
        $res = M('notice')->add($params);
        if ($res) {
            $this->redirect('Index/index');
        } else {
            $this->error('发布失败，请重试');
        }
    }
}