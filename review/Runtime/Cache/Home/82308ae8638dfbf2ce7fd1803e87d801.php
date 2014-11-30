<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>添加评论</title>
</head>
<body>

<form action="/review/index.php/Home/Review/AddReview" method="post" enctype="multipart/form-data">

评分：<br>
<input type="radio" name="score" value="1" checked="checked" />1分 
<input type="radio" name="score" value="2" />2分 
<input type="radio" name="score" value="3" />3分
<input type="radio" name="score" value="4" />4分 
<input type="radio" name="score" value="5" />5分
<br><br>

标签：<br>
<input type="checkbox" name="tag_name[]" value ="送货快" >送货快<br>
<input type="checkbox" name="tag_name[]" value ="新鲜">新鲜<br>
<input type="checkbox" name="tag_name[]" value ="口感好">口感好<br>
<br><br>


评论内容：<br><textarea name="comment"></textarea><br><br>


晒单：<br>
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