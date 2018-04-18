<?php

namespace Home\Model;

use Think\Model;

class CostModel extends Model
{
    public function getList($pagination = false, $pageIndex = null)
    {
        if ($pagination) {
            $costlList = $this->page($pageIndex . ',' . C('PAGE_SIZE'))->select();
        } else {
            $costlList = $this->select();
        }
        $costlList = array_map(function ($value) {
            $map = array(
                'user_id' => $value['user_id']
            );
            $userData = M('user')->where($map)->field('user_name')->find();
            $value['user_name'] = $userData['user_name'];
            return $value;
        }, $costlList);
        return $costlList;

    }

    public function getCount()
    {
        return $this->count();
    }


    public function create($params)
    {
        $params['created_at'] = time();
        $params['total'] = $params['ticket'] + $params['traffic'] + $params['stay'] + $params['other'];
        return $this->add($params);
    }

    public function changeStatus($cost_id, $status)
    {
        $data = array(
            'status' => $status,
            'updated_at' => time()
        );
        return $this->where(array('cost_id' => $cost_id))->save($data);
    }

    public function confirmStatus($cost_id, $status)
    {
        $data = array(
            'confirm_status' => $status,
            'updated_at' => time()
        );
        return $this->where(array('cost_id' => $cost_id))->save($data);
    }
}