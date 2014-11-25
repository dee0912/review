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
		$data['score'] = $score = $_POST['score'];														//评分
		$data['comment'] = $comment = $_POST['comment'];									//评论内容
		$data['member_id'] = $member_id = $_POST['member_id'];							//用户id
		$data['order_id'] = $order_id = $_POST['order_id'];										//订单id
		$data['product_id'] = $product_id = $_POST['product_id'];							//商品id
		$data['sale_prop'] = $sale_prop = $_POST['sale_prop'];								//商品销售属性
				
		
		//用户id为空
		if($member_id == ""){
			
			$error = 1;
			exit(json_encode($error));
		}
				
		//订单id为空
		if($order_id == ""){
			
			$error = 2;
			exit(json_encode($error));
		}
		
		//评论为空
		if($comment == ""){
			 
			$error = 3;
			exit(json_encode($error));
		}
		
		//商品id为空
		if($product_id == ""){
		
			$error = 4;
			exit(json_encode($error));
		}
		
		//商品销售属性为空
		if($sale_prop == ""){
			
			$error = 5;
			exit(json_encode($error));
		}
		

		//查询订单时间
		$orderObj = D("Order");	//在订单表中查询
		if(!$order_time = $orderObj->where('order_id='.$order_id)->getField('order_time')){
			
			//查询不到订单时间
			$error = 2;
			exit(json_encode($error));
			
		}else{
			
			$data['order_time'] = $order_time;
		}

		
		//添加评论时间
		$data['creation_time'] = $creation_time = date("Y-m-d H:i:s",time());
				
		//添加评论
		$reviewObj = D("Review");
		if($review_id = $reviewObj->data($data)->add()){
			
			//添加tag
			$tagData['tag_name'] = 	 $tag_name = json_encode($_POST['tag_name']);		//标签名称			
			$tagData['review_id'] = $review_id;
			$tagData['creation_time'] = $creation_time;
			$tagObj = D("Tag");
			if($tagObj->data($tagData)->add()){
				
				$flag = 1; //添加成功		
				exit(json_encode($flag));
			}else{
			
				$flag = 0;//添加失败
				exit(json_encode($flag));
			}
				
		}else{
			
			$flag = 0;//添加失败
			exit(json_encode($flag));
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//数据限制
/*		$rules = array(     
			
			 array('$comment','require','评论不能为空'),
			 array('$score',array(1,2,3,4,5),'值的范围不正确！',2,'in'), 
			 
		);
	
		$reviewObj = D("Review");
		
		if (!$reviewObj->validate($rules)->create()){     
		
			// 如果创建失败 表示验证没有通过 输出错误提示信息     
			exit($reviewObj->getError());
			
		}else{    

			// 验证通过 可以进行其他数据操作
		}*/

		
/*		$this->assign("score",$_POST['score']);
		$this->assign("tag_name",$_POST['tag_name']);
				
		$this->assign("comment",$_POST['comment']);
		$this->assign("member_id",$_POST['member_id']);
		$this->assign("order_id",$_POST['order_id']);
		$this->assign("product_id",$_POST['product_id']);
		$this->display();*/
	}
}