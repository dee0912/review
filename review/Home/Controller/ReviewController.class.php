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
                    exit(json_encode(array("error"=>$error)));
            }

            //订单id为空
            if($order_id == ""){

                    $error = 2;
                    exit(json_encode(array("error"=>$error)));
            }

            //评论为空
            if($comment == ""){

                    $error = 3;
                    exit(json_encode(array("error"=>$error)));
            }

            //商品id为空
            if($product_id == ""){

                    $error = 4;
                    exit(json_encode(array("error"=>$error)));
            }

            //商品销售属性为空
            if($sale_prop == ""){

                    $error = 5;
                    exit(json_encode(array("error"=>$error)));
            }

            //查询订单时间
            $orderObj = D("Order");	//在订单表中查询
            $orderObj->create();
            if(!$order_time = $orderObj->where('order_id='.$order_id)->getField('order_time')){

                //查询不到订单时间
                $error = 2;
                exit(json_encode(array("error"=>$error)));
                
            }else{

                $data['order_time'] = $order_time;
            }

            //添加评论时间
            $data['creation_time'] = $creation_time = date("Y-m-d H:i:s",time());
            
                 
            //添加评论
            $reviewObj = D("Review");
            $reviewObj->create();
            if($review_id = $reviewObj->data($data)->add()){

               //添加评论成功后，如果标签不为空，则添加tag至标签表
               if($_POST['tag_name']!=""){

                    $tag_name = implode('|',I('tag_name')); 
                    $tagData['tag_name'] = $tag_name ; //标签名称
                    $tagData['review_id'] = $review_id;
                    $tagData['creation_time'] = $creation_time;
                    $tagObj = D("Tag");
                    $tagObj->create();
                    if(!$tagObj->data($tagData)->add()){

                        //添加tag失败
                        $error = 7;
                        exit(json_encode(array("error"=>$error)));
                    }
               }

               //添加url和priority至order_show_pic表
               if($_FILES['myfile']!=""){
                          
                    // 实例化上传类
                    $upload = new \Think\Upload();
                    $upload->maxSize   =     1000000 ;                                  // 设置附件上传大小    1M
                    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');        // 设置附件上传类型
                    $upload->savePath  =      "/Home/";                                 // 设置附件上传目录,对应review/Uploads/Home
           
                    $info = $upload->upload();
           
                    if(!$info) {

                        //上传失败
                        $error = 6;
                        exit(json_encode(array("error"=>$error)));
                    }
                                 
                    $picObj = D("Order_show_pic");
                    $picObj->create();

                    //取出并添加图片url
                    foreach($info as $key=>$file){

                        $picData['url'] = $file['savepath'].$file['savename'];
                        $picData['review_id'] = $review_id;
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

                        if(!$picObj->data($picData)->add()){

                            //图片添加失败
                            $error = 8;
                            exit(json_encode(array("error"=>$error)));
                        }
                    }
               }

               //评论添加成功
               $flag = 1; 
               exit(json_encode(array("flag"=>$flag)));

           }else{

               //评论添加失败
               $flag = 0;
               exit(json_encode(array("flag"=>$flag)));
           }
                 
             
    }

	/*****************************************后台****************************************************/
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


        //接收get参数
        if(isset($_GET['product_id'])){

                //商品id
                $product_id = I('product_id');
                $where = " product_id=".$product_id;
        }

        if(isset($_GET['member_id'])){

                //用户id
                $member_id = I('member_id');
                $where = " member_id=".$member_id;
        }

        if(isset($_GET['is_enabled'])){

                //是否启用 1- 启用 0-禁用
                $is_enabled = I('is_enabled');
                $where = " is_enabled=".$is_enabled;
        }

        if(isset($_GET['has_ordershow'])){

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


	/*********************************获取一条评论的详情**********************************************/
	public function getReview(){

		//评论id有误
		if(!isset($_GET['review_id']) && $_GET['review_id'] == ""){

			$error = 1;
			exit(json_encode(array("error"=>$error)));
		}

		$where = "review.review_id=".$_GET['review_id'];

		//查询
		$reviewObj = D("Review");
                $picObj = D("Order_show_pic");
                $tagObj = D("Tag");

		if($reviewCount = $reviewObj->where($where)->count() > 0){

                    //$review = $reviewObj->where($where)->select();

                    $review = $picObj
                    ->join('RIGHT JOIN review On review.review_id = order_show_pic.review_id LEFT JOIN tag On tag.review_id = review.review_id')
                    ->field('review.review_id,review.member_id,review.order_id,review.product_id,review.sale_prop,review.creation_time,review.comment,review.score,review.is_enabled,review.order_top,order_show_pic.url,tag.tag_name')
                    //->group("review.review_id")
                    ->where($where)
                    ->select();
                    //file_put_contents("D:/mylog.log",$picObj->getLastSql()."\r\n", FILE_APPEND);
                }else{
                    
                    //没有查询结果
                    $error = 2;
                    exit(json_encode(array("error"=>$error)));
                }
                //file_put_contents('D:/mylog.log',json_encode($review)."\r\n",FILE_APPEND);
		exit(json_encode($review));
                //exit(json_encode(array("review"=>$review,"pic"=>$pic,"tag"=>$tag)));

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


	/************************************后台获取评论列表********************************************/

	public function searchReview(){   //分配参数

		$Review = M('Review'); // 实例化User对象
		$Order_show_pic = M("Order_show_pic");

		//含有查询条件时
		$where = "";
                
                //初始页数
                isset($_GET['p'])?$p = $_GET['p']:$p = 1;
                //每页的记录数
                isset($_GET['perpage'])?$perpage = $_GET['perpage']:$perpage = 5;
             
		//没有查询信息时
		//if(!$_POST['submit']){
                  if(!isset($_GET['start_date']) && !isset($_GET['end_date']) && !isset($_GET['product_id']) && !isset($_GET['order_id'])){



			// 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
			$list = $Review
				->join('LEFT JOIN order_show_pic On review.review_id = order_show_pic.review_id')
				->field('review.review_id,review.member_id,review.order_id,review.product_id,review.sale_prop,review.creation_time,review.comment,review.is_enabled,review.order_top,order_show_pic.url')
				->group("review.review_id")
                                ->order('review.order_top desc,review.creation_time desc')
				//->page($p.','.$perpage)
                                ->limit($perpage*($p-1),$perpage)
				->select();
                        //file_put_contents("D:/mylog.log",$Review->getLastSql()."\r\n", FILE_APPEND);
                        $count = $Review->count();// 查询满足要求的总记录数
			//echo $Review->getLastSql();exit();
                        //file_put_contents("D:/mylog.log",$Review->getLastSql()."\r\n", FILE_APPEND);
		}else{

			//判断参数
			$f = 0;

			$start_date = I("start_date");
			$end_date = I("end_date");
			$product_id = I("product_id");
			$order_id = I("order_id");

			//评论时间
			if(($start_date != "" && $end_date == "") || ($start_date == "" && $end_date != "") || ($start_date != "" && $end_date != "" && $start_date > $end_date)){

				exit(json_encode(array("error"=>1)));

			}else if($start_date == "" && $end_date ==""){

				$f = 0;

			}else{

				//时间正确
				$where .= " review.creation_time>='".$start_date."' and review.creation_time<='".date("Y-m-d H:i:s",strtotime("$end_date+1 day"))."'";

				//有第一个参数，f值赋1
				$f = 1;
			}

			//商品编码
			if($product_id != ""){

				if($f == 0){

					$where .= " product_id=".$product_id;

				}else{

					$where .= " and product_id=".$product_id;

				}

				$f = 1;

			}

			//订单编号
			if($order_id != ""){

				if($f == 0){

					$where .= " order_id=".$order_id;

					$f = 1;

				}else{

					$where .= " and order_id=".$order_id;

					$f = 1;
				}

			}
		$list = $Review
		->join('LEFT JOIN order_show_pic On review.review_id = order_show_pic.review_id')
		->field('review.review_id,review.member_id,review.order_id,review.product_id,review.sale_prop,review.creation_time,review.comment,review.is_enabled,review.order_top,order_show_pic.url')
		->where($where)
		->order('review.order_top desc,review.creation_time desc')
		//->page($p.','.$perpage)
                ->limit($perpage*($p-1),$perpage)
		->select();
                
		//echo $Review->getLastSql();exit();
                //file_put_contents("D:/mylog.log",$Review->getLastSql()."\r\n", FILE_APPEND);
                $count = $Review
		->join('LEFT JOIN order_show_pic On review.review_id = order_show_pic.review_id')
		->field('review.review_id,review.member_id,review.order_id,review.product_id,review.sale_prop,review.creation_time,review.comment,review.is_enabled,review.order_top,order_show_pic.url')
		->where($where)
		->order('review.order_top desc,review.creation_time desc')
		//->page($p.','.$perpage)
                ->limit($perpage*($p-1),$perpage)
                ->count();   // 查询满足要求的总记录数
		}

		//$count = $Review->count();// 查询满足要求的总记录数

		//分页
		//$Page = new \Think\Page($count,$perpage);			// 实例化分页类 传入总记录数和每页显示的记录数
		//$show = $Page->show();								// 分页显示输出
		//echo $show;exit();
		//exit(json_encode(array("count"=>$count,"list"=>$list,"show"=>$show)));
                exit(json_encode(array("count"=>$count,"list"=>$list)));

	}

	/***************************管理员启用/禁用评论**********************************/
	public function setEnabled(){

		$Review = D("Review");
                $datetime = date("Y-m-d H:i:s",time());
		if( isset($_POST['state']) && isset($_POST['review_id']) ){

			if( $_POST['state'] ==0 ){

				$Review->query("update review set is_enabled = 1,modification_time = '".$datetime."' where review_id=".$_POST['review_id']);

				echo 1;

			}else{

				$Review->query("update review set is_enabled = 0,modification_time = '".$datetime."' where review_id=".$_POST['review_id']);

				echo 0;
			}

			//file_put_contents('D:/mylog.log',$Review->getLastSql()."\r\n",FILE_APPEND);

		}
	}
        
        
        
        /***************************管理员置顶**********************************/
         public function setTop(){
 
             $ReviewObj = D("Review");
             $datetime = date("Y-m-d H:i:s",time());
 
             if( isset($_POST['isTop']) && isset($_POST['review_id']) ){
                 
                    if( $_POST['isTop'] == 0 ){ //没有置顶

                            $ReviewObj->query("update review set order_top = 10,modification_time = '".$datetime."' where review_id=".$_POST['review_id']);
                                                        
                            echo 1;//置顶

                    }else{ //已经是置顶

                            $ReviewObj->query("update review set order_top = 1,modification_time = '".$datetime."' where review_id=".$_POST['review_id']);
                                                        
                            echo 0;//取消置顶
                    }    
                    //file_put_contents('D:/mylog.log',$Review->getLastSql()."\r\n",FILE_APPEND);
             }
             
         }
         
        /***********************管理员添加评论**************************************/
        public function AdminAddReview(){

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
                        exit(json_encode(array("error"=>$error)));
                }

                //订单id为空
                if($order_id == ""){

                        $error = 2;
                        exit(json_encode(array("error"=>$error)));
                }

                //评论为空
                if($comment == ""){

                        $error = 3;
                        exit(json_encode(array("error"=>$error)));
                }

                //商品id为空
                if($product_id == ""){

                        $error = 4;
                        exit(json_encode(array("error"=>$error)));
                }

                //商品销售属性为空
                if($sale_prop == ""){

                        $error = 5;
                        exit(json_encode(array("error"=>$error)));
                }

                //查询订单时间
                $orderObj = D("Order");	//在订单表中查询
                $orderObj->create();
                if(!$order_time = $orderObj->where('order_id='.$order_id)->getField('order_time')){

                    //查询不到订单时间
                    $error = 2;
                    exit(json_encode(array("error"=>$error)));

                }else{

                    $data['order_time'] = $order_time;
                }

                //添加评论时间
                $data['creation_time'] = $creation_time = date("Y-m-d H:i:s",time());


                //添加评论
                $reviewObj = D("Review");
                $reviewObj->create();
                if($review_id = $reviewObj->data($data)->add()){

                   //添加评论成功后，如果标签不为空，则添加tag至标签表
                   if($_POST['tag_name']!=""){

                        $tag_name = implode('|',I('tag_name')); 
                        $tagData['tag_name'] = $tag_name ; //标签名称
                        $tagData['review_id'] = $review_id;
                        $tagData['creation_time'] = $creation_time;
                        $tagObj = D("Tag");
                        $tagObj->create();
                        if(!$tagObj->data($tagData)->add()){

                            //添加tag失败
                            $error = 7;
                            exit(json_encode(array("error"=>$error)));
                        }
                   }

                   //添加url和priority至order_show_pic表
                   if($_FILES['myfile']!=""){

                        // 实例化上传类
                        $upload = new \Think\Upload();
                        $upload->maxSize   =     1000000 ;                                  // 设置附件上传大小    1M
                        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');        // 设置附件上传类型
                        $upload->savePath  =      "/Home/";                                 // 设置附件上传目录,对应review/Uploads/Home

                        $info = $upload->upload();

                        if(!$info) {

                            //上传失败
                            $error = 6;
                            exit(json_encode(array("error"=>$error)));
                        }

                        $picObj = D("Order_show_pic");
                        $picObj->create();

                        //取出并添加图片url
                        foreach($info as $key=>$file){

                            $picData['url'] = $file['savepath'].$file['savename'];
                            $picData['review_id'] = $review_id;
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

                            if(!$picObj->data($picData)->add()){

                                //图片添加失败
                                $error = 8;
                                exit(json_encode(array("error"=>$error)));
                            }
                        }
                   }

                   //评论添加成功
                   $flag = 1; 
                   exit(json_encode(array("flag"=>$flag)));

               }else{

                   //评论添加失败
                   $flag = 0;
                   exit(json_encode(array("flag"=>$flag)));
               }


        }























}