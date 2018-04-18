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

            $value['isSendCostRequest'] = false;
            $res = M('cost')->where(array('approval_id' => $value['approval_id']))->find();
            $res && $value['isSendCostRequest'] = true;
            return $value;
        }, $approvalList);
        return $approvalList;

    }

    public function getCount()
    {
        return $this->count();
    }

    public function changeStatus($approval_id, $status)
    {
        $data = array(
            'status' => $status,
            'updated_at' => time()
        );
        return $this->where(array('approval_id' => $approval_id))->save($data);
    }

    public function confirmStatus($approval_id, $status)
    {
        $data = array(
            'confirm_status' => $status,
            'updated_at' => time()
        );
        return $this->where(array('approval_id' => $approval_id))->save($data);
    }
}