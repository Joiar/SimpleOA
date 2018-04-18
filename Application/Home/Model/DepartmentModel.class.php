<?php

namespace Home\Model;

use Think\Model;

class DepartmentModel extends Model
{
    public function getList($pagination = false, $pageIndex = null)
    {
        if ($pagination) {
            $departmentList = $this->page($pageIndex . ',' . C('PAGE_SIZE'))->select();
        } else {
            $departmentList = $this->select();
        }
        return $departmentList;
    }

    public function getCount()
    {
        return $this->count();
    }

    public function addDepartment($name)
    {
        $res = $this->add(array(
            'department_name' => $name,
            'created_at' => time()
        ));
        return $res;
    }

    public function deleteDepartment($id)
    {
        return $this->delete($id);
    }
}