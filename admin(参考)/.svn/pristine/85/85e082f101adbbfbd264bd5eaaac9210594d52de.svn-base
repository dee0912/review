__page = 1;
__page_total = 0;
__page_size = 20;

function bindPage(callback, page_count) {

    __page_total = page_count;

    isShowPage(callback);

    $("#prePage").unbind("click").bind("click", function () {
        __page--;

        if (__page <= 0) {
            __page = 1;
        }

        if (typeof (callback) == 'function') {
            callback();

        }


    });

    $("#nextPage").unbind("click").bind("click", function () {
        __page++;

        if (typeof (callback) == 'function')
        {
            callback();
        }

    });

}

function isShowPage(callback) {

    if (__page_total > 3) {
        if (__page == 1) {
            $("#prePage").hide();
        }
        else {
            $("#prePage").show();
        }

        if (__page >= __page_total) {
            $("#nextPage").hide();
        }
        else {
            $("#nextPage").show();
        }
    }

    if (__page_total <= 1)
        __page_total = 1;

    if (__page_total % 10 > 0 && __page_total > 1)
        __page_total++;

    $(".page_list").empty();
    var is_print_point = false;

    for (var i = 1; i <= __page_total; i++) {
        var is_select = i == __page ? 'color_red' : '';

        if (__page_total <= 10) {
            $(".page_list").append("<span class='" + is_select + "'> " + i + " </span>");
        }
        else {
            if (i <= 3) {
                $(".page_list").append("<span class='" + is_select + "'> " + i + " </span>");
            }
            else if (i >= __page_total - 3) {
                $(".page_list").append("<span class='" + is_select + "'> " + i + " </span>");


            }
            else if (__page == i) {
                if (__page > 4 && __page < __page_total - 4) {
                    $(".page_list").append("..<span class=''> " + (i - 1) + " </span>");
                    $(".page_list").append("<span class='" + is_select + "'> " + i + " </span>");
                    $(".page_list").append("<span class=''> " + (i + 1) + " </span>..");
                }
                else if (__page == 4) {
                    $(".page_list").append("<span class='" + is_select + "'> " + i + " </span>..");

                } else {
                    $(".page_list").append("..<span class='" + is_select + "'> " + i + " </span>");
                }
            }
            else {
                if (!is_print_point) {
                    is_print_point = true;
                    $(".page_list").append("<font class='is_print_point'>..</font>");
                }

                if (__page >= 4 && (__page <= __page_total - 4)) {
                    $(".page_list").find("font[class='is_print_point']").remove();//情况多余的标点
                }

                continue;
            }

        }
    }

    $(".page_list").find("span").each(function () {

        $(this).unbind("click").bind("click", function () {
            __page = parseInt($(this).html());

            if (__page <= 0)
                __page = 1;

            if (typeof (callback) == 'function') {
                callback();
            }

        });

    });

}

