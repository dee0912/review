<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link href="<?php echo (SITE_URL); ?>/Public/Admin/css/common.css" rel="stylesheet" type="text/css">
<link href="<?php echo (SITE_URL); ?>/Public/Admin/css/ui-dialog.css" rel="stylesheet" type="text/css">
<link href="<?php echo (SITE_URL); ?>/Public/Admin/css/admin.css" rel="stylesheet" type="text/css">
<script src="<?php echo (SITE_URL); ?>/Public/Admin/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo (SITE_URL); ?>/Public/Admin/js/review.js"></script>
</head>
<body>

<!-- 遮罩 -->
<div id="rbox">
    <a class="go" href="#" onclick="return false;">关闭</a>

    <table class="gridtable">
            <thead>
                    <tr>
                            <th>商品编码</th>
                            <th>商品名称</th>
                            <th>评论时间</th>
                            <th>评论用户</th>
                            <th>晒单图片</th>
                            <th>评论内容</th>
                            <th>评分</th>
                            <th>标签</th>
                    </tr>
            </thead>
            <tbody align="center">
                    <tr>
                            <td class="product_id"></td>
                            <td class="sale_prop"></td>
                            <td class="creation_time"></td>
                            <td class="member_id"></td>
                            <td class="url"></td>
                            <td class="comment"></td>
                            <td class="score"></td>
                            <td class="tag"></td>
                    </tr>
            </tbody>
    </table>
</div>
<div id="mask"></div>
    
评论查询：
<!--  <form action="<?php echo U('Review/Review/searchReview');?>" method="post"> -->
<form action="/review/index.php/Admin/Admin/getList/" method="post">
评论时间：<input type="date" name="start_date"> 至 <input type="date" name="end_date">
商品编码：<input type="text" name="product_id">
订单编号：<input type="text" name="order_id"><br><br>
<input type="submit" name="submit" value="查询">
</form><br><br><a class="viewmore" href="#" onclick="return false">新增评价</a>
<br><br>
评论列表（共有<font color="red"><?php echo ($count); ?></font>条数据）<br><br>
<table class="gridtable">
	<thead>
		<tr>
			<th>订单编号</th>
			<th>商品编码</th>
			<th>商品名称</th>
			<th>评论时间</th>
			<th>评论图片</th>
			<th>评论内容</th>
			<th>评论用户</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody id="admin_role_list" align="center">
	   <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="<?php echo ($vo["review_id"]); ?>">
			<td><?php echo ($vo["order_id"]); ?></td>
			<td><?php echo ($vo["product_id"]); ?></td>
			<td><?php echo ($vo["sale_prop"]); ?></td>
			<td><?php echo ($vo["creation_time"]); ?></td>
                        <td>
                             <?php if(($vo["url"] != '') ): ?><img src="<?php echo (UPLOADS_FILE); echo ($vo["url"]); ?>" width="100"><?php endif; ?>
                        </td>
			<td><?php echo ($vo["comment"]); ?></td>
			<td><?php echo ($vo["member_id"]); ?></td>
			<td><span class="state">
                                <?php if(($vo["is_enabled"] == 1) ): ?><font color="green">启用</font>
                                <?php else: ?>
                                    <font color="red"> 禁用</font><?php endif; ?>
                            </span>
                        </td>
			<td>
                            <span><a class="viewmore" href="#" onclick="return false">查看</a></span>&nbsp;&nbsp;
                            <span class="set-enabled state<?php echo ($vo["is_enabled"]); ?>"></span>&nbsp;&nbsp;
                            <span class="setTop top<?php echo ($vo["order_top"]); ?>">
                                <?php if(($vo["order_top"] == 1) ): ?><font color="green">置顶</font>
                                <?php else: ?>
                                    <font color="red"> 取消置顶</font><?php endif; ?>
                            </span>
                        </td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</tbody>
</table>


<?php echo ($show); ?>

</body>
<script>

$(function(){

	//管理员启用/禁用评论
       $(".set-enabled").each(function(){

		if($(this).hasClass("state0")){

			$(this).html("<font color='green'>启用</font>");
			
		}else{

			$(this).html("<font color='red'>禁用</font>");
		}
	});

	$(".set-enabled").click(function(){

                $(this).hasClass("state0")?(state = 0):(state = 1);
                if($(this).hasClass("state0")){
                    
                    $(this).removeClass("state0");
                }else{
                    
                    $(this).removeClass("state1");
                }
                
                obj = $(this);

		//$.post("http://admin.huangdi.com/index.php/Home/Review/setEnabled/",{
                $.post("http://127.0.0.28/review/index.php/Home/Review/setEnabled/",{
		
			state:state,
			review_id:$(this).parents("tr").attr("class"),
					
		},function(data,textStatus){
						
                    if(data == 0){

                            obj.addClass("state0")
                                   .html("<font color='green'>启用</font>");
                            obj.parent().prev().children(":first").html("<font color='red'>禁用</font>");

                    }else{

                            obj.addClass("state1")
                                .html("<font color='red'>禁用</font>");
                            obj.parent().prev().children(":first").html("<font color='green'>启用</font>")
                    }
			
		});
	});
	

        //管理员置顶评论        
        $(".setTop").click(function(){
           
                //是否已经是置顶状态
                $(this).hasClass("top1")?(isTop = 0):(isTop = 1); //有class top1表示没有置顶

                if(isTop == 0){ //没有置顶
                  
                    $(this).removeClass("top1");
                    
                }else{
                 
                    $(this).removeClass("top10");
                }
                
                obj = $(this);

		//$.post("http://admin.huangdi.com/index.php/Home/Review/setEnabled/",{
                $.post("http://127.0.0.28/review/index.php/Home/Review/setTop/",{
		
			isTop:isTop,
			review_id:$(this).parents("tr").attr("class"),
					
		},function(data,textStatus){
				
                        if(data == 0){

                                obj.addClass("top1")
                                   .html("<font color='green'>置顶</font>");
   
                        }else{

                                obj.addClass("top10")
                                    .html("<font color='red'>取消置顶</font>");
                        }
			
		});          
        });



    
        //查看更多
        $(".viewmore").click(function(){

            if(window.screen.availHeight > $(document.body).outerHeight(true)){

                //当屏幕可用工作区域的高度 > 浏览器当前窗口文档body的总高度 包括border padding margin时( 缩放时 )
                $("#mask").show().css({"opacity":"0.5","width":"100%","height":window.screen.availHeight});
            }else{

                $("#mask").show().css({"opacity":"0.5","width":"100%","height":$(document.body).outerHeight(true)});
            }            
            $("#rbox").show();  
            
            //ajax
  
            //$.post("http://admin.huangdi.com/index.php/Home/Review/getReview/",{
            $.post("http://127.0.0.28/review/index.php/Admin/Admin/getReview/",{

                    review_id:$(this).parents("tr").attr("class"),

            },function(data,textStatus){

                var dataObj=eval("("+data+")");

                $.each(dataObj,function(idx,item){ 

                  $(".product_id").html(item.product_id);
                  $(".sale_prop").html(item.sale_prop);
                  $(".creation_time").html(item.creation_time);
                  $(".member_id").html(item.member_id);
                 
                  if(!item.url){
              
                    $(".url").html("没有图片");
                  }else{
                  
                    $(".url").html("<img src=<?php echo (UPLOADS_FILE); ?>"+item.url+" width=100>");
                  }
                  $(".comment").html(item.comment);
                  $(".score").html(item.score);
                  
                  if(!item.tag_name){
                  
                      $(".tag").html("没有标签");
                  }else{
                      
                      $(".tag").html(item.tag_name);
                  }
                });
                
            });            
        });    


        //根据浏览器可视窗口的变化调整遮罩的宽度和高度,使遮罩充满浏览器
        $(window).resize(function(){            

            //根据浏览器窗口变化改变遮罩宽度和高度,使遮罩充满整个浏览器    
            if($("#mask").css("width")!=0){

                $("#mask").css("width","100%"); //必要时可对宽度也作出判断       

                if(window.screen.availHeight > $(document.body).outerHeight(true)){

                    $("#mask").css({"opacity":"0.5","width":"100%","height":window.screen.availHeight});
                }else{

                    $("#mask").css({"opacity":"0.5","width":"100%","height":$(document.body).outerHeight(true)});
                }
            }
        });

        $(".go").click(function(){

            $("#mask").hide();
            $("#rbox").hide();
        });
    });
	

</script>
</html>