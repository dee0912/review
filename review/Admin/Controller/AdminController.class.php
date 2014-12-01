<?php
namespace Admin\Controller;
use Think\Controller;

class AdminController extends Controller{


	//获取后台评论列表
        public function getList(){
          
                //每页记录数
		$perpage = 5;
                //当前页
                $p = $_GET['p'] == ""?1:$_GET['p'];
 
                $pageInfo = "perpage/".$perpage."/p/".$p."/";

                //$url = "http://admin.huangdi.com/index.php/Home/Review/searchReview/";
                if(!$_POST['submit']){
                
                    $url = "http://admin.huangdi.com/review/index.php/Home/Review/searchReview/".$pageInfo;
           
                }else{
                        
                    $param = "";
                    if($_POST['start_date'] != "" && $_POST['end_date'] != ""){
                        
                        $param .= "start_date/".$_POST['start_date']."/end_date/".$_POST['end_date']."/"; 
                    }
                    
                    if($_POST['product_id'] != ""){
                        
                        $param .= "product_id/".$_POST['product_id']."/";
                    }
                    
                    if($_POST['order_id'] != ""){
                        
                        $param .= "order_id/".$_POST['order_id']."/";
                    }
                    
                    $url = "http://admin.huangdi.com/review/index.php/Home/Review/searchReview/".$param."/".$pageInfo;
                    
                }
                
		$handle = fopen("$url","rb");
		$content = "";
	
                while(!feof($handle)){
		
			$content .= fread($handle,10000);
		}
		fclose($handel);
	  	
		$content = json_decode($content,true);
				
		//分页
		$Page       = new \Think\Page($content['count'],$perpage);			// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();								// 分页显示输出	
		
		$this->assign("count",$content['count']);
		$this->assign("list",$content['list']);
		//$this->assign("show",$content['show']);
                $this->assign("show",$show);
		$this->display();
		
	}
	
	//查看单条评论详情
        public function getReview(){
            
		$review_id = $_POST['review_id'];
                //$url = "http://admin.huangdi.com/index.php/Home/Review/getReview/";
                $url = "http://admin.huangdi.com/review/index.php/Home/Review/getReview/review_id/".$review_id;
		$handle = fopen($url,"rb");
		$content = "";
                        
		while(!feof($handle)){
		
			$content .= fread($handle,10000);
		}
		fclose($handel);
		
                echo $content;
		
	}
        
       //管理员后台添加商品评论
        public function addReview(){
            
            $product_id = I("product_id");
            $order_id = I("order_id");
            $member_name = I("member_name");
            $member_id = I("member_id");
            
            $comment = I("comment");
            $score = I("score");
            $tag_name = I("tag_name");
            $sale_prop = I("sale_prop");
            
            $param = "product_id/".$product_id."/order_id/".$order_id."/member_name/".$member_name."/comment/".$comment."/score/".$score."/sale_prop/".$sale_prop."/";
            
            if($_FILES['myfile']!=""){ $myfile = $_FILE['myfile']; $param .= "myfile/".$myfile."/";}
            
            if($_POST['tag_name']!=""){ $tag_name = $_POST['tag_name']; $param .= "tag_name/".$tag_name."/";}
            
            $url = "http://admin.huangdi.com/review/index.php/Home/Review/AdminAddReview/".$param;
            echo $url;exit();
            
            $handle = fopen($url,"rb");
            $content = "";

            while(!feof($handle)){

                    $content .= fread($handle,10000);
            }
            fclose($handel);

            echo $content;
            
            
        }
}