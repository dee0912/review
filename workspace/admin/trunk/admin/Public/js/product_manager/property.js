(function (window) {
    var butAdd = $("#butAdd");
    var btnSearch = $("#btnSearch");

    function property() {
    }

    property.getPropertyTypeList = function (select_obj, callback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "/Property/getPropertyTypeList",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {},
            success: function (returnData) {
                if (returnData) {
                    select_obj.empty();
                    select_obj.append("<option value='-1'>请选择</option>");

                    $.each(returnData, function (idx, val) {
                        select_obj.append("<option value='" + val.type_id + "'>" + val.type_name + "</option>");
                    });


                    if (typeof (callback) === 'function')
                        callback();
                }

            }
        });
    };

    property.bindClickEvent = function () {
        butAdd.on("click", function () {
            property.add();
        });

        btnSearch.on("click", function () {
            property.searchProperty();
        });


    }


    property.add = function () {
        var d = dialog({
            title: '添加属性',
            content: $("#addPop").html(),
            width: 450,
            okValue: '保存',
            ok: function () {
                var pop = $(".ui-dialog-body");
                //提交验证
                if (property.editValidate(pop))
                {
                    var property_name = pop.find("#property_name").val();
                    var property_type = parseInt(pop.find("#property_type_list").val());
                    this.title('提交中…');
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: "/Property/add",
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        data: {property_id: 0, property_name: property_name, property_type: property_type},
                        success: function (returnData) {
                            if (returnData) {
                                d.close();
                                property.searchProperty();
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
        pop.find("#lab_property_id").parent().parent().hide();
        //载入分类信息
        property.getPropertyTypeList(pop.find("#property_type_list"));

    };


    //查询列表
    property.searchProperty = function () {
        var property_name = $.trim($("#txt_property_name").val());
        var property_type = $("#property_type_list").val();

        //取得角色组列表
        $("#property_list").empty();

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "/Property/search",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {page: __page, page_size: __page_size, property_name: property_name, property_type: property_type},
            success: function (returnData) {
                //console.log(returnData);
                var total_count = returnData["count"];
                $("#property_count").html(total_count);

                var _list = $("#property_list");

                if (returnData["count"] > 0) {
                    var _html = "";

                    $.each(returnData["list"], function (i, item) {
                        _html += "<tr data-id='" + item.property_id + "' data-value='" + JSON.stringify(item) + "'>";
                        _html += "<td>" + item.property_id + "</td>";
                         _html += "<td>" + item.type_name + "</td>";
                        _html += "<td>" + item.property_name + "</td>";
                        _html += "<td>" + item.update_time + "</td>";
                        _html += "<td>" + item.update_by + "</td>";
                        _html += "<td><a class='edit'>编辑</a> <a class='delete'>删除</a></td>";
                        _html += "</tr>";
                    });
                    _list.append(_html);

                    bindOption();
                }

                function bindOption() {
                    //编辑
                    _list.find(".edit").unbind("click").click(function () {
                        var _id = $(this).parent().parent().attr("data-id");
                        var _tr_info = $.parseJSON($(this).parent().parent().attr("data-value"));
                        if (_id > 0) {
                            var d = dialog({
                                title: '编辑属性',
                                content: $("#addPop").html(),
                                width: 450,
                                okValue: '保存',
                                ok: function () {
                                    var pop = $(".ui-dialog-body");
                                    //提交验证
                                    if (property.editValidate(pop))
                                    {
                                        var property_id = pop.find("#property_id").val();
                                        var property_name = $.trim(pop.find("#property_name").val());
                                        var property_type = parseInt(pop.find("#property_type_list").val());

                                        this.title('提交中…');
                                        $.ajax({
                                            type: 'post',
                                            dataType: 'json',
                                            url: "/Property/add",
                                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                            data: {property_id: property_id, property_name: property_name, property_type: property_type},
                                            success: function (returnData) {
                                                if (returnData) {
                                                    d.close();
                                                    property.searchProperty();
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
                            pop.find("#property_id").val(_tr_info.property_id);
                            pop.find("#lab_property_id").html(_tr_info.property_id);
                            pop.find("#property_name").val(_tr_info.property_name);
                            property.getPropertyTypeList(pop.find("#property_type_list"), function () {
                                pop.find("#property_type_list").val(_tr_info.type_id);
                            });
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
                                        url: "/Property/delete",
                                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                        data: {property_id: _id},
                                        success: function (returnData) {
                                            if (returnData) {
                                                d.close();
                                                property.searchProperty();
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
                }

            }
        });
    };

    //验证
    property.editValidate = function (pop) {
        var property_name_obj = pop.find("#property_name");
        var property_type_list_obj = pop.find("#property_type_list");

        if (parseInt(property_type_list_obj.val()) < 0) {
            property_type_list_obj.next().html("请选择属性类别");
            return false;
        }
        else
            property_type_list_obj.next().html("");

        if ($.trim(property_name_obj.val()).length <= 0) {
            property_name_obj.next().html("属性名称不能为空");
            return false;
        }
        else
            property_name_obj.next().html("");

        return true;
    };


    window.Property = property;

})(window);