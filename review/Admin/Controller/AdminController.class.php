<?php
namespace Admin\Controller;
use Think\Controller;

class AdminController extends Controller{


	//获取后台评论列表
        public function getList(){
            
                //每页记录数
		$perpage = 5;
                //当前页
                $p = $_GET['p'];
 
                $pageInfo = "perpage/".$perpage."/p/".$p."/";

                //$url = "http://admin.huangdi.com/index.php/Home/Review/searchReview/";
                if(!$_POST['submit']){
                
                    $url = "http://127.0.0.28/review/index.php/Home/Review/searchReview/".$pageInfo;
              
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
                    
                    $url = "http://127.0.0.28/review/index.php/Home/Review/searchReview/".$param."/".$pageInfo;
                    
                }
                
		$handle = fopen($url,"rb");
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
                $url = "http://127.0.0.28/review/index.php/Home/Review/getReview/review_id/".$review_id;
		$handle = fopen($url,"rb");
		$content = "";
		while(!feof($handle)){
		
			$content .= fread($handle,10000);
		}
		fclose($handel);
		
                echo $content;
		
	}
}