<?php

namespace Home\Controller;

use Think\Controller;

class ApprovalController extends Controller
{
    /**
     * add
     * 2018/4/18
     */
    public function add()
    {
        $this->display('add');
    }

    /**
     * doAdd
     * 2018/4/18
     */
    public function doAdd()
    {
        $approvalData = I('post.approval_data');
        $approvalData['user_id'] = session('UserData.user_id');
        $approvalData['department_id'] = session('UserData.department_id');
        $approvalMdl = D('approval');
        $res = $approvalMdl->create($approvalData);
        if ($res) {
            $this->redirect('Approval/showList');
        } else {
            $this->error('添加失败，请重试');
        }
    }

    public function addCost()
    {
        $costMdl = D('cost');
        $params = I('post.formdata');
        $params['department_id'] = session('UserData.department_id');
        $res = $costMdl->create($params);
        if ($res) {
            $this->redirect('Approval/showList');
        } else {
            $this->error('发起费用失败，请重试');
        }
    }

    public function showList()
    {
        if (session('UserData.department_id') != 1) {
            $map = array('department_id' => session('UserData.department_id'));
        } else {
            $map = array();
        }
        $pageIndex = I('get.p') ? I('get.p') : 1;
        $approvalMdl = D('approval');
        $approvalList = $approvalMdl->getList(true, $pageIndex, $map);
        $this->assign('approval_list', $approvalList);

        $count = $approvalMdl->getCount();
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
        $this->display('list');
    }

    public function showCostList()
    {
        if (session('UserData.department_id') != 2) {
            $map = array('department_id' => session('UserData.department_id'));
        } else {
            $map = array();
        }
        $pageIndex = I('get.p') ? I('get.p') : 1;
        $costMdl = D('cost');
        $costList = $costMdl->getList(true, $pageIndex);
        $this->assign('cost_list', $costList);

        $count = $costMdl->getCount();
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
        $this->display('costList');
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

    /**
     * changeStatus
     * 2018/4/18
     */
    public function changeStatus()
    {
        $approval_id = I('post.approval_id');
        $status = I('post.status');
        $approvalMdl = D('approval');
        $res = $approvalMdl->changeStatus($approval_id, $status);
        if ($res) {
            $this->ajaxReturn(array(
                'status' => 1,
                'msg' => '操作成功',
                'data' => array()
            ));
        } else {
            $this->ajaxReturn(array(
                'status' => 0,
                'msg' => '操作失败',
                'data' => array()
            ));
        }
    }

    /**
     * confirmStatus
     * 2018/4/18
     */
    public function confirmStatus()
    {
        $approval_id = I('post.approval_id');
        $status = I('post.status');
        $approvalMdl = D('approval');
        $res = $approvalMdl->confirmStatus($approval_id, $status);
        if ($res) {
            $this->ajaxReturn(array(
                'status' => 1,
                'msg' => '操作成功',
                'data' => array()
            ));
        } else {
            $this->ajaxReturn(array(
                'status' => 0,
                'msg' => '操作失败',
                'data' => array()
            ));
        }
    }

    /**
     * changeStatus
     * 2018/4/18
     */
    public function changeCostStatus()
    {
        $cost_id = I('post.cost_id');
        $status = I('post.status');
        $costMdl = D('cost');
        $res = $costMdl->changeStatus($cost_id, $status);
        if ($res) {
            $this->ajaxReturn(array(
                'status' => 1,
                'msg' => '操作成功',
                'data' => array()
            ));
        } else {
            $this->ajaxReturn(array(
                'status' => 0,
                'msg' => '操作失败',
                'data' => array()
            ));
        }
    }

    /**
     * confirmStatus
     * 2018/4/18
     */
    public function confirmCostStatus()
    {
        $cost_id = I('post.cost_id');
        $status = I('post.status');
        $costMdl = D('cost');
        $res = $costMdl->confirmStatus($cost_id, $status);
        if ($res) {
            $this->ajaxReturn(array(
                'status' => 1,
                'msg' => '操作成功',
                'data' => array()
            ));
        } else {
            $this->ajaxReturn(array(
                'status' => 0,
                'msg' => '操作失败',
                'data' => array()
            ));
        }
    }
}