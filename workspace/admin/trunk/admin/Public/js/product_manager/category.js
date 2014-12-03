(function (window) {
    var btnSearch = $("#btnSearch");
    var butAddCategory = $("#butAddCategory");
    var __category_tree;

    function category() {
    }

    category.bindClickEvent = function () {
        //搜索按钮
        btnSearch.on("click", function () {
            //
        });
        butAddCategory.on("click", function () {
            category.addCategory();
        });
    }

    category.loadCategory = function (parent_id, idx) {//父分类ID,第几个下拉框索引
        var current_select_idx = idx;
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "/Category/getCategory",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {parent_id: parent_id},
            success: function (returnData) {

                $("#category_select_" + current_select_idx).empty();
                $("#category_select_" + current_select_idx).append("<option value='-1'>请选择</option>")

                if (returnData) {

                    $.each(returnData, function (indx, item) {
                        $("#category_select_" + current_select_idx).append("<option value='" + item.category_id + "'>" + item.category_name + "</option>")
                    });
                    //绑定事件
                    $("#category_select_" + current_select_idx).on("change", function () {

                        var current_select_category_id = parseInt($(this).children('option:selected').val());
                        $("#category_id").val(current_select_category_id);
                        //载入下级分类
                        category.loadCategory(current_select_category_id, current_select_idx + 1);
                    })
                }
            }
        });
    };
    category.loadPopCategory = function (pop, parent_id, idx) {//父分类ID,第几个下拉框索引
        var current_select_idx = idx;
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "/Category/getCategory",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {parent_id: parent_id},
            success: function (returnData) {

                pop.find("#category_select_" + current_select_idx).empty().show();
                pop.find("#category_select_" + current_select_idx).append("<option value='-1'>请选择</option>");
                //后面的需要隐藏
                pop.find("#category_select_" + current_select_idx).nextAll("select").each(function () {
                    var current_select = $(this);
                    current_select.empty().hide();
                    current_select.append("<option value='-1'>请选择</option>");
                });
                if (returnData) {

                    $.each(returnData, function (indx, item) {
                        pop.find("#category_select_" + current_select_idx).append("<option value='" + item.category_id + "'>" + item.category_name + "</option>")
                    });
                    //绑定事件
                    pop.find("#category_select_" + current_select_idx).on("change", function () {

                        var current_select_category_id = parseInt($(this).children('option:selected').val());
                        pop.find("#parent_id").val(current_select_category_id);
                        //载入下级分类
                        category.loadPopCategory(pop, current_select_category_id, current_select_idx + 1);
                    })
                }
            }
        });
    };
    category.searchCategory = function () {

        
        //取得角色组列表
        $("#category_list").empty();
        __category_tree = new Array();

        var category_id = parseInt($("#category_id").val());
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "/Category/search",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {category_id: category_id},
            success: function (returnData) {
                //console.log(returnData);
                var total_count = returnData["count"];
                $("#category_count").html(total_count);

                var _list = $("#category_list");

                if (returnData["count"] > 0) {
                    var role_html = "";

                    var cat_list = category.getCategoryTree(returnData["list"], 0, 0);
                    //console.log(cat_list);
                    $.each(cat_list, function (i, item) {
                        var show_class = "";
                        if (item.parent_id > 0)
                            show_class = 'none';

                        role_html += "<tr data-id='" + item.category_id + "' data-value='" + JSON.stringify(item) + "' class='" + show_class + " parent_id_" + item.parent_id + "'>";
                        role_html += "<td>" + item.category_id;

                        if (item.children_cat_count > 0) {
                            role_html += "<a class='cat_show_tree'>[+]</a>";
                        }

                        role_html += "</td>";

                        var step = item.step;
                        if (step == 0)
                            role_html += "<td>" + item.category_name + "</td><td></td><td></td><td></td>";
                        else if (step == 1)
                            role_html += "<td></td><td>" + item.category_name + "</td><td></td><td></td>";
                        else if (step == 2)
                            role_html += "<td></td><td></td><td>" + item.category_name + "</td><td></td>";
                        else if (step == 3)
                            role_html += "<td></td><td></td><td></td><td>" + item.category_name + "</td>";

                        role_html += "<td>" + item.sort_value + "</td>";
                        role_html += "<td>" + item.update_time + "</td>";
                        role_html += "<td>" + item.update_by + "</td>";
                        role_html += "<td><a class='edit'>编辑</a> <a class='delete'>删除</a></td>";
                        role_html += "</tr>";
                    });
                    _list.append(role_html);

                    bindOption();

                }

                function bindOption() {
                    //编辑
                    _list.find(".edit").unbind("click").click(function () {
                        var _id = $(this).parent().parent().attr("data-id");
                        var _cate_info = $.parseJSON($(this).parent().parent().attr("data-value"));
                        if (_id > 0) {
                            var d = dialog({
                                title: '编辑类目',
                                content: $("#editCategoryPop").html(),
                                width: 450,
                                okValue: '保存',
                                ok: function () {
                                    var pop = $(".ui-dialog-body");
                                    //提交验证
                                    if (category.editCategoryValidate(pop))
                                    {
                                        var category_name = pop.find("#category_name").val();
                                        var parent_id = parseInt(pop.find("#parent_id").val());
                                        var sort_value = parseInt(pop.find("#sort_value").val());
                                        var comment = pop.find("#comment").val();
                                        //计算category_path
                                        var category_path = "";
                                        pop.find("select[id^='category_select_']").each(function () {
                                            var current_select_val = parseInt($(this).val());
                                            if (current_select_val > -1) {
                                                category_path += current_select_val + ",";
                                            }
                                            else
                                                return false;
                                        });
                                        this.title('提交中…');
                                        $.ajax({
                                            type: 'post',
                                            dataType: 'json',
                                            url: "/Category/add",
                                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                            data: {category_id: _cate_info.category_id, category_name: category_name, parent_id: parent_id, sort_value: sort_value, comment: comment, category_path: category_path},
                                            success: function (returnData) {
                                                if (returnData) {
                                                    d.close();
                                                    window.Category.searchCategory();
                                                }
                                            }
                                        });
                                        return true;
                                    } else {
                                        return false;
                                    }

                                },
                                cancelValue: '取消',
                                cancel: function () {
                                }
                            });
                            d.showModal();
                            //载入数据信息
                            var pop = $(".ui-dialog-body");
                            pop.find("#category_name").val(_cate_info.category_name);
                            pop.find("#sort_value").val(_cate_info.sort_value);
                            pop.find("#comment").val(_cate_info.comment);
                            category.getCategoryTreeInfo(_cate_info.category_path, pop);
                        }
                    });
                    //删除
                    _list.find(".delete").unbind("click").click(function () {
                        var _id = $(this).parent().parent().attr("data-id");
                        if (_id > 0) {

                            var d = dialog({
                                title: '是否删除',
                                content: '',
                                okValue: '确定',
                                ok: function () {
                                    this.title('提交中…');
                                    $.ajax({
                                        type: 'post',
                                        dataType: 'json',
                                        url: "/Category/delete",
                                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                        data: {category_id: _id},
                                        success: function (returnData) {
                                            if (returnData) {
                                                d.close();
                                                window.Category.searchCategory();
                                            }
                                        }
                                    });
                                    return false;
                                },
                                cancelValue: '取消',
                                cancel: function () {
                                }
                            });
                            d.show();
                        }
                    });
                    //展开
                    _list.find(".cat_show_tree").on("click", function () {
                        var _id = $(this).parent().parent().attr("data-id");
                        if (_list.find(".parent_id_" + _id).is(":visible")) {
                            _list.find(".parent_id_" + _id).hide();//对应二级

                            //对应三级
                            var child_cat_id1 = _list.find(".parent_id_" + _id).eq(0).attr("data-id");
                            if (child_cat_id1 > 0) {
                                _list.find(".parent_id_" + child_cat_id1).hide();

                                //对应四级
                                var child_cat_id2 = _list.find(".parent_id_" + child_cat_id1).eq(0).attr("data-id");
                                if (child_cat_id2 > 0) {
                                    _list.find(".parent_id_" + child_cat_id2).hide();
                                }
                            }

                        }
                        else
                            _list.find(".parent_id_" + _id).show("fast");
                    });
                }

            }
        });
    };
    //取得分类树

    category.getCategoryTree = function (arr, pid, step) {

        $.each(arr, function (idx, val) {
            var current_cate_id = val['category_id'];
            var current_parent_id = val['parent_id'];

            if (current_parent_id == pid) {
                //定义步长
                val['step'] = step;
                //计算子分类的个数
                var parent_cat = category.getArrayByCatetory(arr, pid);
                if (parent_cat) {
                    if (typeof (parent_cat["children_cat_count"]) === 'undefined')
                        parent_cat["children_cat_count"] = 0;

                    parent_cat["children_cat_count"] += 1;
                }
                //追加到数组
                __category_tree.push(val);

                category.getCategoryTree(arr, current_cate_id, step + 1);
            }
        });

        return __category_tree;
    };


    category.getArrayByCatetory = function (arr, cat_id) {

        var return_val = null;

        $.each(arr, function (idx, val) {
            if (val["category_id"] == cat_id) {
                return_val = val;
                return false;
            }
        });

        return return_val;
    }


//添加分类
    category.addCategory = function () {

        var d = dialog({
            title: '添加类目',
            content: $("#addCategoryPop").html(),
            width: 450,
            okValue: '保存',
            ok: function () {
                var pop = $(".ui-dialog-body");
                //提交验证
                if (category.editCategoryValidate(pop))
                {
                    var category_name = $.trim(pop.find("#category_name").val());
                    var parent_id = parseInt(pop.find("#parent_id").val());
                    var sort_value = parseInt(pop.find("#sort_value").val());
                    var comment = pop.find("#comment").val();

                    //计算category_path
                    var category_path = "";
                    pop.find("select[id^='category_select_']").each(function () {
                        var current_select_val = parseInt($(this).val());
                        if (current_select_val > -1) {
                            category_path += current_select_val + ",";
                        }
                        else
                            return false;
                    });
                    this.title('提交中…');
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: "/Category/add",
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        data: {category_name: category_name, parent_id: parent_id, sort_value: sort_value, comment: comment, category_path: category_path},
                        success: function (returnData) {
                            if (returnData) {
                                d.close();
                                window.Category.searchCategory();
                            }
                        }
                    });
                    return true;
                } else {
                    return false;
                }

            },
            cancelValue: '取消',
            cancel: function () {
            }
        });
        d.showModal();

        var pop = $(".ui-dialog-body");

        //载入分类信息
        category.loadPopCategory(pop, 0, 1);

        //权限检测
        var ary_operation = get_operation(window.permission_operation);
        if ("101".in_array(ary_operation)) {
            pop.find("#sort_value").attr("disabled", "disabled");
        }

    }

//取得分类书信息
    category.getCategoryTreeInfo = function (category_path, pop) {

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "/Category/getCategoryTreeInfo",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {category_path: category_path},
            success: function (returnData) {
                if (returnData) {
                    pop.find("#category_tree_info").html("");
                    $.each(returnData, function (i, item) {
                        pop.find("#category_tree_info").append(item.category_name + " > ");
                    });
                }
            }
        });
    };
    //分类提交验证
    category.editCategoryValidate = function (pop) {
        var category_name_obj = pop.find("#category_name");
        var category_sort = pop.find("#sort_value");
        if ($.trim(category_name_obj.val()).length <= 0) {
            category_name_obj.next().html("分类名称不能为空");
            return false;
        }
        else
            category_name_obj.next().html("");

        if (parseInt(category_sort.val()) < 0) {
            category_sort.next().html("排序不能请勿小于零");
            return false;
        }
        else
            category_sort.next().html("");

        return true;
    }


    window.Category = category;
})(window);