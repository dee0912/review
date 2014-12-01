<?php

namespace Admin\Controller;


/**
 * Description of PropertyController
 *
 * @author benzhiqiang
 */
class PropertyController extends BaseController {

    public function index() {
        $this->display();
    }

    public function getPropertyTypeList() {

        //从数据库里面调取信息
        $select_table = M('', '', 'DB_PRODUCT');
        $sql_select = "SELECT type_id,type_name FROM property_type where status=1";
        $list_info = $select_table->query($sql_select);

        echo json_encode($list_info);
    }

    public function search() {
        $page = I("page");
        $page_size = I("page_size");
        $property_name = I("property_name");
        $property_type = I("property_type");

        //从数据库里面调取信息
        $select_table = M('', '', 'DB_PRODUCT');

        $_where = "INNER JOIN property_type prt on pr.property_type=prt.type_id and  prt.status=1 where pr.status=1 ";
        if (strlen($property_name) > 0)
            $_where .= " AND pr.property_name LIKE '%" . $property_name . "%'";
        if ($property_type > 0)
            $_where .= " AND pr.property_type = " . $property_type;


        $sql_select = "select property_id,property_name,prt.type_name,prt.type_id,pr.update_time,pr.update_by from property pr " . $_where . " limit " . ($page - 1) * $page_size . "," . $page_size;
        $list_info = $select_table->query($sql_select);

        $sql_select_count = "select count(*) as count from property pr " . $_where;
        $select_count = $select_table->query($sql_select_count);


        $return_array = array();
        $return_array["count"] = $select_count[0]["count"];
        $return_array["list"] = $list_info;

        echo json_encode($return_array);
    }

    public function delete() {
        $property_id = I("property_id");

        if ($property_id > 0) {
            $delete_table = M('', '', 'DB_PRODUCT');
            $sql = "update property set status=-1 where property_id= " . $property_id;
            $exec_result = $delete_table->execute($sql);

            if ($exec_result > 0) {
                echo json_encode(true);
                return;
            }
        }

        echo json_encode(false);
    }

    public function add() {
        $data["property_id"] = I("property_id");
        $data["property_name"] = I("property_name");
        $data["property_type"] = I("property_type");
        $data["status"] = 1;
        $data["update_time"] = date('Y-m-d');
        $data["update_by"] = 1;


        if ($data["property_id"] > 0) {
            $model = D('Property');
            if (!$model->create($data)) {
                exit(json_encode($model->getError()));
            } else {
                $setdata = array(
                    'property_name' => $data["property_name"],
                    'property_type' => $data["property_type"],
                    'update_time' => date('Y-m-d'),
                    'update_by' => 1
                );

                $model->where('property_id=' . $data["property_id"])->setField($setdata);

                exit(json_encode(true));
            }
        } else {
            $model = D('Property');
            if (!$model->create($data)) {
                exit(json_encode($model->getError()));
            } else {
                $new_id = $model->add($data);

                exit(json_encode(true));
            }
        }

        json_encode(false);
        return;
    }

}
