$(function () {

    getAdminRoleList();


    function getAdminRoleList() {

        //取得角色组列表
        $("#admin_role_list").empty();

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "/AdminRole/search",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {page: __page, page_size: __page_size},
            success: function (returnData) {
                //console.log(returnData);
                var total_count = returnData["count"];
                $("#admin_role_count").html(total_count);
                var list_role = $("#admin_role_list");

                if (returnData["count"] > 0) {
                    
                    var role_html = "";
                    $.each(returnData["list"], function (i, item) {
                        role_html += "<tr data-id='" + item.role_id + "'>";
                        role_html += "<td>" + item.role_name + "</td>";
                        role_html += "<td></td>";
                        role_html += "<td><a href='/AdminRole/addIndex/role_id/"+item.role_id+"'>编辑</a> <a class='delete'>删除</a></td>";
                        role_html += "</tr>";
                    });

                    list_role.append(role_html);

                    bingOption();
                    bindPage(getAdminRoleList, total_count / __page_size);

                }

                function bingOption() {
                    //删除
                    list_role.find(".delete").unbind("click").click(function () {
                        var role_id = $(this).parent().parent().attr("data-id");

                        if (role_id > 0) {

                            var d = dialog({
                                title: '是否删除',
                                content: '',
                                okValue: '确定',
                                ok: function () {
                                    this.title('提交中…');

                                    $.ajax({
                                        type: 'post',
                                        dataType: 'json',
                                        url: "/AdminRole/delete",
                                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                        data: {role_id: role_id },
                                        success: function (returnData) {
                                            if(returnData){
                                                d.close();
                                                getAdminRoleList();
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
    }

})