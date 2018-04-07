<?php

namespace Home\Model;

use Think\Model;

class DepartmentModel extends Model
{
    public function getList()
    {
        $departmentList = $this->select();
        return $departmentList;
    }
}