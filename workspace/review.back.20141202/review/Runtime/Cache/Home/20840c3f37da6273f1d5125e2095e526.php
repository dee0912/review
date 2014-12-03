<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>

<form action="/index.php/Home/Review/UpdateStatus" method="post">

<input type="radio" name="is_enabled" value="1" checked="checked">启用
<input type="radio" name="is_enabled" value="0" >禁用
<input type="hidden" name="review_id" value="17">

<input type="submit" value="提交">

</form>


</body>
</html>