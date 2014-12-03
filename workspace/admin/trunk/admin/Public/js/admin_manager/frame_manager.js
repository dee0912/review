(function (window) {

    var menu_level_1 = $(".menu_level_1");

    function frame_manager() {
    }

    frame_manager.initFrame = function () {
        var current_window_height = $(window).height();
        var current_window_width = $(window).width();

        var frame_left_width = 200;
        var frame_top_height = $(".frame_top").height();

        //定义框架左边
        $(".frame_left").width(frame_left_width);
        $(".frame_left").height(current_window_height - frame_top_height);


        //定义框架右边
        $(".frame_right").css("max-width", current_window_width - frame_left_width - 20 + "px");
        $(".frame_right").height(current_window_height - frame_top_height);

        //绑定点击事件
        frame_manager.menuClickEvent();

    };

    //菜单点击事件
    frame_manager.menuClickEvent = function () {
        menu_level_1.children("li").each(function () {
            $(this).on("click", function () {
                $(".menu_level_2").hide();
                $(this).next().show("fast");
            })

        });
    };

    window.FrameManager = frame_manager;

})(window);