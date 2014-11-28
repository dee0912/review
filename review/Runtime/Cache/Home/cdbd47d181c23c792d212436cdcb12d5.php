<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link href="/Public/css/common.css" rel="stylesheet" type="text/css">
<link href="/Public/css/ui-dialog.css" rel="stylesheet" type="text/css">
</head>
<body>

评论列表（共有<font color="red">1</font>条数据）<br><br>
<table class="gridtable">
	<thead>
		<tr>
			<th>订单编号</th>
			<th>商品编码</th>
			<th>商品名称</th>
			<th>评论用户</th>
			<th>评论时间</th>
			<th>评论内容</th>
			<th>评分</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody id="admin_role_list">
	   <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
			<td><?php echo ($vo["order_id"]); ?></td>
			<td><?php echo ($vo["product_id"]); ?></td>
			<td><?php echo ($vo["sale_prop"]); ?></td>
			<td><?php echo ($vo["member_id"]); ?></td>
			<td><?php echo ($vo["creation_time"]); ?></td>
			<td><?php echo ($vo["comment"]); ?></td>
			<td><?php echo ($vo["review_score"]); ?></td>
			<td><?php echo ($vo["is_enabled"]); ?></td>
			<td>查看&nbsp;&nbsp;禁用</td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</tbody>
</table>


<?php echo ($page); ?>
</body>
</html>