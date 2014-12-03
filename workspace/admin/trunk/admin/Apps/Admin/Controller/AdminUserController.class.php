<?php

namespace Admin\Controller;

use Think\Controller;

class AdminUserController extends BaseController {

    public function index() {
        $this->assign('search_url', UR('AdminUser/search'));
        $this->assign('query_url', UR('AdminUser/get'));
        $this->assign('save_url', UR('AdminUser/modify'));
        $this->assign('del_url', UR('AdminUser/del'));

        //获取部门列表
        $deptObj = M('department', '', 'DB_PERMISSION');
        $dept_list = $deptObj->field('department_id,display_name as department_name')->where('is_enabled=1')->select();
        $this->assign('dept_list', $dept_list);

        //获取角色列表
        $roleObj = M('role', '', 'DB_PERMISSION');
        $role_list = $roleObj->field('role_id,display_name as role_name')->where('is_enabled=1')->select();
        $this->assign('role_list', $role_list);
        $this->display();
    }

    /*
     * 编辑后台管理员
     */

    public function modify() {
        $user_id = I('user_id') > 0 ? (int) I('user_id') : 0;
        $dept_id = I('dept_id') > 0 ? (int) I('dept_id') : 0;
        $role_list = I('role_list');
        $status = I('status');
        $warehouse_ids = I("warehouse_ids");

        if ($user_id == 0 || $dept_id == 0 || count($role_list) == 0) {
            echo 1; //用户提交信息错误
            exit();
        }

        //修改用户基本信息
        $userObj = M('user', '', 'DB_PERMISSION');
        $setdata = array(
            'is_enabled' => $status,
            'warehouse_ids' => $warehouse_ids,
            'modification_time' => date('Y-m-d'),
        );
        $userObj->where('user_id=' . $user_id)->setField($setdata);

        $now_time = date('Y-m-d H:i:s', time());
        //修改用户部门信息
        $user_dept = M('department', '', 'DB_PERMISSION');
        $dept_info = $user_dept->query("SELECT department.department_id FROM department LEFT JOIN `user` u on u.department_id=department.department_id where u.user_id='" . $user_id . "'");

        if ($dept_info[0]['department_id'] > 0) {
            //修改用户-部门关系
            if ($dept_info[0]['department_id'] != $dept_id) {
                $dept_info[0]['department_id'] = $dept_id;
                $flag = $user_dept->where('user_id=' . $user_id)->save($dept_info[0]);
                if (!$flag) {
                    echo 2;
                    exit();
                }
            }
        } else {
            //添加用户-部门关系
            $dept_info['user_id'] = $user_id;
            $dept_info['department_id'] = $dept_id;
            $dept_info['status'] = 1;
            $dept_info['update_time'] = $now_time;
            $dept_info['add_time'] = $now_time;
            $map_id = $user_dept->add($dept_info);
            if (!$map_id) {
                echo 2;
                exit();
            }
        }

        //修改用户-角色关系
        $user_role = M('user_role_map', '', 'DB_PERMISSION');
        $user_role->where('user_id=' . $user_id)->delete();
        //添加
        $user_role_info['user_id'] = $user_id;
        foreach ($role_list as $role) {
            $user_role_info['role_id'] = $role;
            $user_role->add($user_role_info);
        }
    }

    public function search() {
        $user_name = I('user_name');
        $dept_id = I('dept_id') > 0 ? (int) I('dept_id') : 0;
        $role_id = I('role_id') > 0 ? (int) I('role_id') : 0;
        $status = I('status') > 0 ? (int) I('status') : 0;

        $where = array();
        if ($user_name != '') {
            $where['user_name'] = array('LIKE', "%" . $user_name . "%");
        }

        if ($status == 1 || $status == 2) {
            $where['status'] = $status;
        }

        $userId_list = array();
        if ($dept_id > 0) {
            $userDeptObj = M('department', '', 'DB_PERMISSION');
            $userDept_list = $userDeptObj->where('is_enabled=1 AND department_id=' . $dept_id)->getField('user_id', true);
            if ($userDept_list == false) {
                echo json_encode(array('count' => 0));
                exit();
            } else {
                $userId_list = $userDept_list;
            }
        }

        if ($role_id > 0) {
            $userRoleObj = M('user_role_map', '', 'DB_PERMISSION');
            $userRole_list = $userRoleObj->where('role_id=' . $role_id)->getField('user_id', true);

            if ($userRole_list == FALSE) {
                echo json_encode(array('count' => 0));
                exit();
            }

            if (count($userId_list) > 0) {
                $userId_list = array_intersect($userId_list, $userRole_list);
            } else {
                $userId_list = $userRole_list;
            }
        }

        if (count($userId_list) > 0) {
            $list = array_unique($userId_list);
            $where['user_id'] = array('IN', implode(',', $list));
        }


        $page = I('page') > 0 ? (int) I('page') : 1;
        $page_num = I('page_size') > 0 ? (int) I('page_size') : 10;

        $userObj = M('user', '', 'DB_PERMISSION');
        //查询条数
        $user_nums = $userObj->field('count(*) as num')->where($where)->find();

        $user_list = $userObj->limit(($page - 1) * $page_num, $page_num)->where($where)->select();
        //echo $userObj->getLastSql();

        $userDeptObj = M('department', '', 'DB_PERMISSION');
        $userRoleObj = M('user_role_map', '', 'DB_PERMISSION');
        foreach ($user_list as $key => $value) {
            //$user_list[$key]['last_time'] = date('Y-m-d H:i:s', $value['last_time']);
            //$user_list[$key]['add_time'] = date('Y-m-d H:i:s', $value['add_time']);
            $user_list[$key]['status'] = $value['is_enabled'] == 1 ? '开启' : '关闭';
            $user_list[$key]['real_name'] = !empty($value['true_name']) ? $value['true_name'] : '';
            $user_list[$key]['mobile'] = !empty($value['mobile']) ? $value['mobile'] : '';
            //查询部门
            $dept_name = $userDeptObj->field('department.display_name as name')->join('user ON user.department_id=department.department_id')->where('department.is_enabled=1 AND user.user_id=' . $value['user_id'])->find();
            $user_list[$key]['dept_name'] = !empty($dept_name['name']) ? $dept_name['name'] : '';

            //查询角色
            $sql_admin_role = "SELECT role.display_name role_name  FROM user_role_map LEFT JOIN role on role.role_id= user_role_map.role_id where  user_role_map.user_id='" . $value['user_id'] . "'";
            $role_list = $userRoleObj->query($sql_admin_role);
            $user_role = array();

            if (count($role_list) > 0) {
                foreach ($role_list as $res) {
                    $user_role[] = $res['role_name'];
                }
            }
            $user_list[$key]['role_info'] = count($user_role) ? implode('、', $user_role) : '';
        }
        $user_info = array();
        $user_info['count'] = $user_nums['num'];
        $user_info['list'] = $user_list;

        echo json_encode($user_info);
    }

    /*
     * 查询用户信息
     */

    public function get() {
        $user_id = I('user_id') > 0 ? (int) I('user_id') : 0;
        if ($user_id == 0) {
            echo 2;
            exit();
        } else {
            //获取用户信息
            $userObj = M('user', '', 'DB_PERMISSION');
            $user_info = $userObj->where('user_id=' . $user_id)->find();

            //获取部门信息
            $deptObj = M('department', '', 'DB_PERMISSION');
            $dept_info = $deptObj->query("SELECT department.department_id FROM department LEFT JOIN `user` u on u.department_id=department.department_id where u.user_id='" . $user_id . "'");
            $user_info['department_id'] = $dept_info[0]['department_id'];

            //获取角色信息
            $roleObj = M('user_role_map', '', 'DB_PERMISSION');
            $role_list = $roleObj->field('role_id')->where('user_id=' . $user_id)->select();
            $user_info['role'] = $role_list;
            echo json_encode($user_info);
        }
    }

    /*
     * 删除管理员
     */

    public function del() {
        $user_id = I('user_id') > 0 ? (int) I('user_id') : 0;
        if ($user_id == 0) {
            echo 1;
            exit();
        } else {
            //删除用户-部门信息
            $userDeptObj = M('admin_department_map');
            $userDeptObj->where('user_id=' . $user_id)->delete();

            //删除用户-角色信息
            $userRoleObj = M('admin_role_map');
            $userRoleObj->where('user_id=' . $user_id)->delete();

            //删除用户信息
            $userObj = M('admin_user');
            $flag = $userObj->where('user_id=' . $user_id)->delete();

            if ($flag) {
                echo 2;
            } else {
                echo 3;
            }
        }
    }

}
