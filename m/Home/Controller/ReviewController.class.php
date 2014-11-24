<?php
namespace Home\Controller;
use Think\Controller;

class ReviewController extends Controller{

	//添加界面
	public function addReviewView(){
		
		$this->display();
	}
	
	//添加评论信息
	public function AddReview(){

		//post数据
		$score = $_POST['score'];
		$tag_name = $_POST['tag_name'];
		$comment = $_POST['comment'];
		$member_id = $_POST['member_id'];
		$order_id = $_POST['order_id'];
		$product_id = $_POST['product_id'];
				
		//数据限制
		$rules = array(     
			
			 array('$comment','require','评论不能为空'),
			 array('$score',array(1,2,3,4,5),'值的范围不正确！',2,'in'), 
			 
		);
	
		$reviewObj = D("Review");
		
		if (!$reviewObj->validate($rules)->create()){     
		
			// 如果创建失败 表示验证没有通过 输出错误提示信息     
			exit($reviewObj->getError());
			
		}else{    

			// 验证通过 可以进行其他数据操作
		}

		
/*		$this->assign("score",$_POST['score']);
		$this->assign("tag_name",$_POST['tag_name']);
				
		$this->assign("comment",$_POST['comment']);
		$this->assign("member_id",$_POST['member_id']);
		$this->assign("order_id",$_POST['order_id']);
		$this->assign("product_id",$_POST['product_id']);
		$this->display();*/
	}
}