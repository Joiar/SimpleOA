<?php

namespace Home\Controller;

use Think\Controller;

class ApprovalController extends Controller
{
    public function add()
    {
        $this->display('add');
    }

    public function doAdd()
    {
        $approvalData = I('post.approval_data');
        $approvalData['user_id'] = session('UserData.user_id');
        $approvalMdl = D('approval');
        $res = $approvalMdl->create($approvalData);
        if ($res) {
            $this->redirect('Approval/showList');
        } else {
            $this->error('添加失败，请重试');
        }
    }

    public function showList()
    {
        $pageIndex = I('get.p') ? I('get.p') : 1;
        $approvalMdl = D('approval');
        $approvalList = $approvalMdl->getList(true, $pageIndex);
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
}