<?php

namespace Home\Controller;

use Think\Controller;

class UserController extends Controller
{
    public function showList()
    {
        $pageIndex = I('get.p') ? I('get.p') : 1;
        $userMdl = D('user');
        $userList = $userMdl->getList(true, $pageIndex);
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

    public function delete()
    {
        $user_id = I('post.user_id');
        $userMdl = D('user');
        $res = $userMdl->deleteUser($user_id);
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
}