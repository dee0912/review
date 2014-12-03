<?php

namespace Admin\Controller;

class CategoryController extends BaseController {

    public function query() {

        //$this->assign("permission", self::$permission);
        $this->assign("version", self::$version);
        
        $this->display();
    }

    public function getCategory() {
        $parent_id = I("parent_id");

        if ($parent_id > -1) {
            //从数据库里面调取信息
            $admin_role_table = M('', '', 'DB_PRODUCT');
            $sql_category = "SELECT category_id,category_name,parent_id FROM category where parent_id=" . $parent_id . " and status=1 ORDER BY sort_value asc";
            $category_info = $admin_role_table->query($sql_category);

            echo json_encode($category_info);
        } else
            echo json_encode(null);
    }

    public function search() {
        $category_id = I("category_id");

        $sql_where = "";
        if ($category_id > 0) {
            $sql_where = "parent_id = " . $category_id . " AND ";
        }

        //从数据库里面调取信息
        $category_table = M('', '', 'DB_PRODUCT');
        $sql_category = "SELECT category_id,category_name,parent_id,sort_value,update_time,update_by,comment,category_path FROM category where " . $sql_where . " status=1  order by sort_value asc";
        $category_info = $category_table->query($sql_category);

        $sql_count = "select count(*) as count from category  where " . $sql_where . " status=1";
        $count = $category_table->query($sql_count);

        $return_array = array();
        $return_array["count"] = $count[0]["count"];
        $return_array["list"] = $category_info;

        //打印日志
        //parent::logDebug("打印日志","Category.search");

        echo json_encode($return_array);
    }

    public function delete() {
        $category_id = I("category_id");

        if ($category_id > 0) {
            $category_table = M('', '', 'DB_PRODUCT');
            $sql = "update category set status=-1 where category_id= " . $category_id;
            $exec_result = $category_table->execute($sql);

            if ($exec_result > 0) {
                echo json_encode(true);
                return;
            }
        }

        echo json_encode(false);
    }

    public function add() {
        $data["category_id"] = I("category_id");
        $data["category_name"] = I("category_name");
        $data["parent_id"] = I("parent_id");
        $data["sort_value"] = I("sort_value");
        $data["comment"] = I("comment");
        $data["status"] = 1;
        $data["create_time"] = $data["update_time"] = date('Y-m-d');
        $data["create_by"] = $data["update_by"] = 1;
        $data["category_path"] = I("category_path");

        if ($data["category_id"] > 0) {
            $category = D('Category');
            if (!$category->create($data)) {
                exit(json_encode($category->getError()));
            } else {
                $setdata = array(
                    'category_name' => $data["category_name"],
                    'sort_value' => $data["sort_value"],
                    'comment' => $data["comment"],
                    'update_time' => date('Y-m-d'),
                    'update_by' => 1
                );

                $category->where('category_id=' . $data["category_id"])->setField($setdata);

                exit(json_encode(true));
            }
        } else {
            $category = D('Category');
            if (!$category->create($data)) {
                exit(json_encode($category->getError()));
            } else {
                $new_id = $category->add($data);
                if ($new_id > 0) {
                    //更新category_path
                    $data = array('category_path' => $data["category_path"] . $new_id . ",");
                    $category->where('category_id=' . $new_id)->setField($data);
                }

                exit(json_encode(true));
            }
        }

        json_encode(false);
        return;
    }

    //取得分类数信息
    public function getCategoryTreeInfo() {
        $category_path = substr(I("category_path"), 0, strlen(I("category_path")) - 1);

        if (!$category_path)
            exit(json_encode(false));


        //从数据库里面调取信息
        $category_table = M('', '', 'DB_PRODUCT');
        $sql_category = "SELECT category_name FROM category where category_id IN (" . $category_path . ")";
        $category_info = $category_table->query($sql_category);

        echo json_encode($category_info);
    }

}
