<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>添加晒单</title>
</head>
<body>

<form method="post" action="/review/index.php/Home/Review/AddOrderShow"  enctype="multipart/form-data">

<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
选择文件1：<input type="file" name="myfile[]">顺序：<input type="text" name="priority[]" ><br><br>
选择文件2：<input type="file" name="myfile[]">顺序：<input type="text" name="priority[]"><br><br>
选择文件3：<input type="file" name="myfile[]">顺序：<input type="text" name="priority[]"><br><br>
	
<input type="hidden" name="member_id" value="100100">
<input type="hidden" name="order_id" value="200100100">
<input type="hidden" name="product_id" value="3001001001">
<input type="hidden" name="sale_prop" value="testtttt">

<input type="submit" value="提交">

</form>


</body>
</html>