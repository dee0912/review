<?php
namespace Home\Controller;
use Think\Controller;

class ReviewController extends Controller{

/*****************************************添加评论*******************************************/
	//添加评论界面
	public function addReviewView(){
		
		$this->display();
	}
	
	//添加评论信息
	public function AddReview(){

		//post数据
		$data['score'] = $score =I('score');										//评分
		$data['comment'] = $comment = I("comment");					//评论内容
		$data['member_id'] = $member_id =I('member_id');			//用户id
		$data['order_id'] = $order_id = I('order_id');						//订单id
		$data['product_id'] = $product_id = I('product_id');			//商品id
		$data['sale_prop'] = $sale_prop = I('sale_prop');				//商品销售属性
				
		
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
		$orderObj->create();
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
		$reviewObj->create();
		if($review_id = $reviewObj->data($data)->add()){
			
			//添加tag
			$tagData['tag_name'] = 	 $tag_name = json_encode(I('tag_name'));		//标签名称			
			$tagData['review_id'] = $review_id;
			$tagData['creation_time'] = $creation_time;
			$tagObj = D("Tag");
			$tagObj->create();
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
			
	}

	
	/*************************************添加晒单***********************************************/
	//添加晒单界面
	public function addOrderShowView(){
		
		$this->display();
	}
	
	//添加晒单信息
	public function AddOrderShow(){
	
		//post信息
		$data['member_id'] = $member_id = I('member_id');			//用户id
		$data['order_id'] = $order_id = I('order_id');						//订单id
		$data['product_id'] = $product_id = I('product_id');			//商品id
		$data['sale_prop'] = $sale_prop = I('sale_prop');				//商品销售属性
		
	
		// 实例化上传类 
		$upload = new \Think\Upload();
		$upload->maxSize   =     1000000 ;									// 设置附件上传大小    1M
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');		// 设置附件上传类型   
		$upload->savePath  =      './Uploads/'; 					// 设置附件上传目录
		
		//上传文件
	    $info   =   $upload->upload();    
	    if(!$info) {

	    	//上传失败
	    	$error = 3;
			exit(json_encode($error));    
	    
	    }else{
	    	
	    	// 上传成功 ,先把除了图片url和图片priority的信息插入oeder_show表
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
			

			//添加晒单时间
			$data['creation_time'] = $creation_time = date("Y-m-d H:i:s",time());
	
			//添加晒单
			$orderShowObj = D("OrderShow");
			$orderShowObj->create();
			if($showOrder_id = $orderShowObj->data($data)->add()){
							
				
				//晒单表添加成功时，添加图片url和图片priority至order_show_pic表
				$picObj = D("Order_show_pic");
				$picObj->create();
				
				//取出并添加图片url
				foreach($info as $key=>$file){        
	        	
	        		$picData['url'] = $file['savepath'].$file['savename'];  
	        		$picData['show_id'] = $showOrder_id;
	        		$picData['creation_time'] = $data['creation_time'] ;
	        		
	        		if($_POST['priority'][$key]==""){
	        			
	        			//顺序为空
	        			$_POST['priority'][$key] = 1;
	        		
	        		}else{
	        		
	        			//强制转换为整型
	        			if(!is_numeric($_POST['priority'][$key])){
	        				
	        				$_POST['priority'][$key] = 1;
	        			}
	        		}
	        		
	        		$picData['priority'] = (int)$_POST['priority'][$key];
	        		
	        		
	        		$picObj->data($picData)->add();
	       		 }
	 
	       		
       		 	$flag = 1; //添加成功		
				exit(json_encode($flag));
					
			}else{
				
				$flag = 0;//添加失败
				exit(json_encode($flag));
			}			    	
			
	    }
	    	
	}
	
/*********************************管理员回复评论/晒单**********************************************/

	public function replyView(){
		
		$this->display();
	}
	
	public function reply(){
		
		//post信息
		$review_id = I('review_id');
		$data['reply'] = $reply = I('reply');

		$reviewObj = D("Review");		
		$reviewCount = $reviewObj->where("review_id=".$review_id)->count();
		
		//订单不存在
		if($reviewCount  == 0){
	
			$error = 1;
			exit(json_encode($error));
		}		
		
		//管理员回复为空
		if($reply  == ""){
		
			$error = 2;
			exit(json_encode($error));
		}
		

		$replyObj = D("Review");
		$replyObj->create();
		if($replyObj->where("review_id=".$review_id)->save($data)){
			
			    $flag = 1; //回复成功		
				exit(json_encode($flag));
				
		}else{
			
				$flag = 0; //回复失败		
				exit(json_encode($flag));
		}
		
	}
	
	
/*********************************查询评论列表**********************************************/	
public function getList(){
	
	//查询条件
	//$where = "";
	
	//接收get参数
	if(isset(I('product_id'))){
		
		//商品id
		$product_id = I('product_id');
		$where = " product_id=".$product_id;
	}

	if(isset(I('member_id'))){
		
		//用户id
		$member_id = I('member_id');
		$where = " member_id=".$member_id;
	}
	
	if(isset(I('is_enabled'))){
		
		//是否启用 1- 启用 0-禁用
		$is_enabled = I('is_enabled');
		$where = " is_enabled=".$is_enabled;
	}
	
	if(isset(I('has_ordershow'))){
		
		//是否含有晒单  1-含 0-不含
		$has_ordershow = I('has_ordershow');
		if($has_ordershow == 0){
			
			//不含晒单
			//查询
			$reviewObj = D("Review");
			$rows = $reviewObj->where($where)->select();
			if($reviewObj->count()>0){
				
				$flag = 2;
				exit(json_encode(array( "review"=>$rows,"flag"=>$flag)));
			
			}else{
			
				$flag = 1;
				exit(json_encode(array( "review"=>$rows,"flag"=>$flag)));
			}
									
		}else{
			
			//含晒单
			//查询
			$showObj = D("Order_show");
			$rows = $showObj->where($where)->select();
			
			if($showObj->count()>0){
				
				$flag = 2;
				exit(json_encode(array( "show"=>$rows,"flag"=>$flag)));
			
			}else{
			
				$flag = 1;
				exit(json_encode(array( "show"=>$rows,"flag"=>$flag)));
			}
			
		}
		
	}

	
}
	
	
/*********************************获取一条评论含晒单的详情**********************************************/	
public function getReview(){
	
	//商品id有误
	if(!isset(I('product_id')) && I('product_id') == ""){
		
		$error = 1;
		exit(json_encode($error));
	}
	
	//用户id有误
	if(!isset(I('member_id')) && I('member_id') == ""){
		
		$error = 2;
		exit(json_encode($error));
	}
	
	//订单id有误
	if(!isset(I('order_id')) && I('order_id') == ""){
		
		$error = 3;
		exit(json_encode($error));
	}
	
	$where = "product_id=".$product_id."&&member_id=".$member_id."&&order_id=".$order_id;
	
	//查询
	$reviewObj = D("Review");
	$showObj = D("Order_show");
	
	if($reviewCount = $reviewObj->where($where)->count() > 0){
		
			$review=$reviewObj->where($where)->select();		
	}
	
	if($showCount = $showObj->where($where)->count() > 0){
		
			$show=$showObj->where($where)->select();		
	}
	
	exit(json_encode(array( "review"=>$review,"show"=>$show)));	
	
}
	
	
/***************************************禁用/启用 评论****************************************************/		
/*public function UpdateStatusView(){
	
	$this->display();
}	*/	

public function UpdateStatus(){
	
		//post信息
		$review_id = I('review_id');
		$data['is_enabled'] = $is_enabled = I('is_enabled');

		$reviewObj = D("Review");		
		$reviewCount = $reviewObj->where("review_id=".$review_id)->count();
		
		//评论不存在
		if($reviewCount  == 0){
	
			$error = 1;
			exit(json_encode($error));
		}		
		
		//is_enabled值有误
		if($is_enabled  == "" || $is_enabled>1 || $is_enabled<0){
		
			$error = 2;
			exit(json_encode($error));
		}
		

		$replyObj = D("Review");
		$replyObj->create();
		if($replyObj->where("review_id=".$review_id)->save($data)){
			
			    $flag = 1; //启用/禁用成功		
				exit(json_encode($flag));
				
		}else{
			
				$flag = 0; //启用/禁用失败	
				exit(json_encode($flag));
		}	
}
	
/***************************************禁用/启用 晒单****************************************************/	
public function UpdateStatusShowView(){
	
	$this->display();
}		

public function UpdateStatusShow(){
	
		//post信息
		$show_id = I('show_id');
		$data['is_enabled'] = $is_enabled = I('is_enabled');

		$showObj = D("Order_show");		
		$showCount = $showObj->where("show_id=".$show_id)->count();
		
		//晒单不存在
		if($showCount  == 0){
	
			$error = 1;
			exit(json_encode($error));
		}		
		
		//is_enabled值有误
		if($is_enabled  == "" || $is_enabled>1 || $is_enabled<0){
		
			$error = 2;
			exit(json_encode($error));
		}
		
		$showObj->create();
		if($showObj->where("show_id=".$show_id)->save($data)){
			
			    $flag = 1; //启用/禁用成功		
				exit(json_encode($flag));
				
		}else{
			
				$flag = 0; //启用/禁用失败	
				exit(json_encode($flag));
		}	
}
}