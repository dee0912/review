<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<?php echo ($score); ?><br>
----<br>
<?php if(is_array($tag_name)): $i = 0; $__LIST__ = $tag_name;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo); ?><br><?php endforeach; endif; else: echo "" ;endif; ?>
----<br>
<?php echo ($comment); ?><br>
----<br>
<?php echo ($member_id); ?><br>
<?php echo ($order_id); ?><br>
<?php echo ($product_id); ?><br>
</body>
</html>