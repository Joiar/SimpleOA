<?php

namespace Home\Model;

use Think\Model;

class UserModel extends Model
{
    public function doLogin($params)
    {
        $map = array(
            'user_no' => $params['user_no']
        );
        $userInfo = $this->where($map)->field('user_id, password')->find();

        if (!$userInfo || !password_verify($params['password'], $userInfo['password'])) {
            return false;
        }

        self::storeUserInfo($userInfo['user_id']);
        return true;
    }

    public function storeUserInfo($user_id)
    {
        $map = array(
            'user_id' => $user_id
        );
        $userData = $this->where($map)
            ->join('__DEPARTMENT__ ON __USER__.department_id = __DEPARTMENT__.department_id')
            ->join('__POSITION__ ON __USER__.position_id = __POSITION__.position_id')
            ->field('user_id,user_name,user_no,department_name,position_name,oa_user.created_at,is_admin,oa_user.department_id')
            ->find();
        session('UserData', $userData);
    }

    public function saveNewUser($params) {
        $params['password'] = password_hash('888888', PASSWORD_DEFAULT);
        $params['created_at'] = time();
        return $this->add($params);
    }

    public function getList($pagination = false, $pageIndex = null, $department_only = false)
    {
        $map = array();
        $department_only && $map = array('department_id' => session('UserData.department_id'));
        if ($pagination) {
            $userList = $this->where($map)->page($pageIndex . ',' . C('PAGE_SIZE'))->select();
        } else {
            $userList = $this->where($map)->select();
        }
        $userList = array_map(function ($value) {
            $departmentName = M('department')->field('department_name')->find($value['department_id']);
            $value['department_name'] = $departmentName['department_name'];
            $positionName = M('position')->field('position_name')->find($value['position_id']);
            $value['position_name'] = $positionName['position_name'];
            return $value;
        }, $userList);
        return $userList;
    }

    public function getCount()
    {
        return $this->count();
    }

    public function deleteUser($id)
    {
        return $this->delete($id);
    }
}