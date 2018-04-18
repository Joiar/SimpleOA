<?php

namespace Home\Model;

use Think\Model;

class ApprovalModel extends Model
{
    public function create($data)
    {
        $data['created_at'] = time();
        $res = $this->add($data);
        return $res;
    }
    
    public function getList($pagination = false, $pageIndex = null)
    {
        if ($pagination) {
            $approvalList = $this->page($pageIndex . ',' . C('PAGE_SIZE'))->select();
        } else {
            $approvalList = $this->select();
        }
        $approvalList = array_map(function ($value) {
            $transportationData = C('TRANSPROTATION');
            $value['transportation'] = $transportationData[$value['transportation']];
            $map = array(
                'user_id' => $value['user_id']
            );
            $userData = M('user')->where($map)->field('user_name')->find();
            $value['user_name'] = $userData['user_name'];
            return $value;
        }, $approvalList);
        return $approvalList;

    }

    public function getCount()
    {
        return $this->count();
    }
}