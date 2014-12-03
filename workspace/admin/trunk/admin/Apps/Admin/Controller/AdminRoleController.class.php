<?php

namespace Admin\Controller;

use Admin\Common\ReturnHelper;

class AdminRoleController extends BaseController {

    public function index() {

        $this->assign("version", self::$version);
        $this->display();
    }

    public function search() {
        $page = I("page");
        $page_size = I("page_size");

        //从数据库里面调取信息
        $admin_role_table = M('', '', 'DB_PERMISSION');
        $sql_admin_role = "select role_id,display_name role_name from role where is_enabled=1 limit " . ($page - 1) * $page_size . "," . $page_size;
        $admin_role_info = $admin_role_table->query($sql_admin_role);

        $sql_admin_role_count = "select count(*) as count from role  where is_enabled=1";
        $admin_role_count = $admin_role_table->query($sql_admin_role_count);

        $return_array = array();
        $return_array["count"] = $admin_role_count[0]["count"];
        $return_array["list"] = $admin_role_info;

        echo json_encode($return_array);
    }

    public function delete() {
        $role_id = I("role_id");
        if ($role_id > 0) {
            $admin_role_table = M('', '', 'DB_PERMISSION');
            $sql_admin_role = "update role set is_enabled=-1 where role_id= " . $role_id;
            $exec_result = $admin_role_table->execute($sql_admin_role);

            if ($exec_result > 0) {
                echo json_encode(true);
                return;
            }
        }
        echo json_encode(false);
    }

    //给每个角色组添加权限
    public function addIndex() {
        $menu = M('', '', 'DB_PERMISSION');

        $select_sql = "SELECT system.system_id,system.display_name system_name,module.module_id,module.display_name module_name,f.function_id,f.display_name function_name,operation.operation_id,operation.display_name operation_name FROM system
LEFT JOIN module on module.system_id=system.system_id
LEFT JOIN `function` f on f.module_id = module.module_id
INNER JOIN operation  on operation.function_id = f.function_id
where system.is_enabled=1 AND module.is_enabled=1 AND f.is_enabled=1 AND operation.is_enabled=1";
        $menu_info = $menu->query($select_sql);

        $this->assign("menulist", json_encode($menu_info));
        $this->assign("option_id", "''");

        //如果是修改
        $role_id = I("role_id");
        if ($role_id > 0) {
            $this->assign("role_id", $role_id);

            //获取名称
            $select_sql = "SELECT display_name FROM role WHERE role_id=" . $role_id;
            $option_info = $menu->query($select_sql);
            if ($option_info) {
                $this->assign("role_name", $option_info[0]["display_name"]);
            }
            
            //获取权限
            $select_sql = "SELECT role.display_name,operation_id FROM role_operation_map LEFT JOIN role on role.role_id=role_operation_map.role_id WHERE role_operation_map.role_id=" . $role_id;
            $option_info = $menu->query($select_sql);
            if ($option_info) {
                $this->assign("option_id", json_encode($option_info));
            }
        }


        $this->display();
    }

    //执行添加角色组和权限
    public function add() {

        $return_obj = new ReturnHelper();

        $role_name = I("role_name");
        $option = I("option");
        $role_id = I("role_id");


        if (strlen($role_name) <= 0) {
            $return_obj->setError("权限名称不能为空");
            exit($return_obj->returnJson());
        }

        $role = D('Role');
        $data["display_name"] = $role_name;
        $data["priority"] = 1;
        $data["is_enabled"] = 1;
        $data["is_enabled"] = 1;
        $data["creation_time"] = date('Y-m-d H:i:s');

        if ($role_id <= 0) {//新增
            //检测重名
            $select_sql = "SELECT display_name FROM role where display_name='" . $role_name . "'";
            $role_info = $role->query($select_sql);
            if ($role_info) {
                $return_obj->setError("名称已经存在");
                exit($return_obj->returnJson());
            }


            $new_id = $role->add($data);

            $aryOption = explode(',', $option);

            if ($new_id > 0 && count($aryOption) > 0) {

                foreach ($aryOption as $option_id) {
                    $role_operation_map = D('RoleOperationMap');
                    $data2["role_id"] = $new_id;
                    $data2["operation_id"] = $option_id;
                    $role_operation_map->add($data2);
                }
            }
        } else {//修改
            $role_model = D('Role');
            $setdata = array(
                'display_name' => $role_name,
                'modification_time' => date('Y-m-d'),
            );
            $role_model->where('role_id=' . $role_id)->setField($setdata);

            //map表
            $role_operation_map = M("", "", 'DB_PERMISSION');
            $select_sql = "DELETE FROM role_operation_map WHERE role_id=" . $role_id;
            $role_operation_map->execute($select_sql);


            $aryOption = explode(',', $option);
            $role_operation_map = D("RoleOperationMap");
            foreach ($aryOption as $option_id) {
                $data2["role_id"] = $role_id;
                $data2["operation_id"] = $option_id;
                $role_operation_map->add($data2);
            }
        }

        $return_obj->setSuccess();
        exit($return_obj->returnJson());
    }

    //执行编辑角色组和权限
    public function doEditRole() {
        if (!empty($_POST)) {
            //添加角色
            $role_array = array();
            $now_date = date("Y-m-d H:m:s", time());
            //添加权限
            if (isset($_POST["role_id"]) && !empty($_POST["role_id"])) {
                $role_id = $_POST["role_id"];
                $role = M("", "", 'DB_PERMISSION');
                $where_map["role_id"] = $role_id;
                $permission_array = $role->table("admin_role_permission_map")->where($where_map)->field("permission_id")->select();
                $str = "";
                foreach ($permission_array as $k => $per) {
                    $str.=$per["permission_id"] . ",";
                }
                //先删除与当前角色有关的数据记录
                $per = M("admin_permission", "", 'DB_PERMISSION');
                $map = M("admin_role_permission_map", "", 'DB_PERMISSION');
                $res = $per->delete($str);
                $res = $map->where($where_map)->delete($str);
                //添加权限
                $join_a = "admin_ b on a.menu_id=b.menu_id";
                $join_b = "admin_operation c on a.operation_id=c.operation_id";
                if (!empty($_POST["module_group"])) {
                    $module_group = $_POST["module_group"];
                    foreach ($module_group as $key => $value) {
                        $sql = "";
                        $action = explode("_", $value);
                        $insert_val = $action[0] . "," . $action[1] . "," . $action[2] . "," . $action[3] . ",'" . $now_date . "','" . $now_date . "',1";
                        $sql = "insert into admin_permission (permission_system,permission_module,permission_function,permission_operation,update_time,add_time,status) values(" . $insert_val . ")";
                        $per_id = $per->execute($sql);
                        $last_per_id = $per->getLastInsID();
                        if ($per_id) {
                            $role_per_sql = "";
                            $action = $role_id . "," . $last_per_id . ",'" . $now_date . "','" . $now_date . "',1";
                            $sql = "insert into admin_role_permission_map (role_id,permission_id,update_time,add_time,status) values (" . $action . ")";
                            $map_id = $map->execute($sql);
                        }
                    }
                }
            }
        }
        $this->success("编辑成功！", "/AdminRole/index");
    }

}
