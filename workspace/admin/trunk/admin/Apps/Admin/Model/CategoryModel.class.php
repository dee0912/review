<?php

namespace Admin\Model;

use Think\Model;

class CategoryModel extends Model {

    protected $connection = 'DB_PRODUCT';
    protected $_validate = array(
        array('category_name', 'require', 'category_name,分类名称不能为空'),
        array('parent_id', 'require', 'parent_id,父分类不能为空'),
    );

}
