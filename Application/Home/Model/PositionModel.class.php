<?php

namespace Home\Model;

use Think\Model;

class PositionModel extends Model
{
    public function getList($pagination = false, $pageIndex = null)
    {
        if ($pagination) {
            $positionList = $this->page($pageIndex . ',' . C('PAGE_SIZE'))->select();
        } else {
            $positionList = $this->select();
        }

        $positionList = array_map(function ($value) {
            $departmentData = M('department')->field('department_name')->find($value['department_id']);
            $value['department_name'] = $departmentData['department_name'];
            return $value;
        }, $positionList);
        return $positionList;
    }

    public function getCount()
    {
        return $this->count();
    }

    public function create($params)
    {
        $params['created_at'] = time();
        if ($params['is_admin'] == 'Y') {
            $positionList = $this->where(array('department_id' => $params['department_id']))->select();
            if (!empty($positionList)) {
                $this->where(array('department_id' => $params['department_id']))->save(array('is_admin' => 'N'));
            }
        }
        return $this->add($params);
    }
}