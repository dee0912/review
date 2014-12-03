<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Api\Api;

class ReviewController extends Controller{

    private $api_url = "http://review.huangdi.com/";

    //获取后台评论列表
    public function getList(){

        //每页记录数
        $perpage = 5;
        //当前页
        $page = $_GET['page'] == ""?1:$_GET['page'];
        $pageInfo = "perpage/".$perpage."/page/".$page."/";

        if(!$_POST['submit']){  //列出所有评论

            $url = $this->api_url."Review/searchReview/".$pageInfo;
            $res = Api::request($url);
        }else{  //查询评论

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

            $url = $this->api_url."/Review/searchReview/".$param.$pageInfo;
            $res = Api::request($url,$param);

        }
        //分页
        $P       = new \Think\Page($res[0]['count'],$perpage);      // 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $P->show();                                    // 分页显示输出	

        $this->assign("count",$res[0]['count']);
        $this->assign("list",$res[0]['list']);
        $this->assign("show",$show);
        $this->assign("fasfdfsurl","http://dfs1.chunbo.local:8080/");
        $this->display();		
    }
	
    //查看单条评论详情
    public function getReview(){

            $review_id = $_POST['review_id'];
            $url = $this->api_url."Review/getReview/review_id/".$review_id;
            $handle = fopen($url,"rb");
            $content = "";

            while(!feof($handle)){

                    $content .= fread($handle,10000);
            }
            fclose($handel);

            echo $content;

            //$res = Api::request($url,$review_id);

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

         if(isset($_FILES["myfile"]) && !empty($_FILES["myfile"])){

            $file_name = $_FILES["myfile"]["tmp_name"]; //array

            foreach($file_name as $v){
                
                $return_array = fdfs_upload($v);
                
                if($return_array["res"] == 1){

                    $link[] = $data["myfile"] = $return_array["data"]; //图片链接

                }else{

                    $return["result"] = -1;
                    $return["dis"] = "文件上传失败";
                    exit(json_encode($return)); 
                }
            }
       //print_r($link);exit();

         }   

         if($_POST['tag_name']!=""){ 

             $tag_name = $_POST['tag_name']; 

         }

         $param = array(

            "product_id" => $product_id,
            "order_id" => $order_id,
            "member_name" => $member_name,
            "member_id" => $member_id,

            "comment" => $comment,
            "score" => $score,
            "tag_name" => $tag_name,
            "sale_prop" => $sale_prop,
             
            'link' => $link,
        );

        $url = $this->api_url."Review/AdminAddReview/";

        $ch = curl_init();      
        $timeout = 300;       
        curl_setopt($ch, CURLOPT_URL, $url);    
        curl_setopt($ch, CURLOPT_POST, true);     
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));    //所需传的数组用http_bulid_query()函数处理一下，就ok了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);      
        $handles = curl_exec($ch);      
        curl_close($ch);  
        $json_data = $handles;
        $array = json_decode($json_data,true); 
        
        if($array['flag'] == 1){

            echo "添加成功";
        }
        print_r($array);


     }
        
    //管理员启用/禁用
    public function setEnabled(){

        $state = I("state");
        $review_id = I("review_id");

        $param = array(
            "state"=>$state,
            "review_id"=>$review_id
        );            
        $url = $this->api_url."Review/setEnabled";
        $type = "post";

        $res = Api::request($url,$param,"post");
        if($res[0] == 1){

             echo 1;
        }else{

             echo 0;
        }           
    }

    //管理员置顶
    public function setTop(){

        $isTop = I("isTop");
        $review_id = I("review_id");

        $param = array(
            "isTop"=>$isTop,
            "review_id"=>$review_id
        );           
        $url = $this->api_url."Review/setTop";
        $type = "post";

        $res = Api::request($url,$param,$type);

        if($res[0] == 1){

             echo 1;
        }else{

             echo 0;
        }                   
    }
        

    
    
    
    
    
    
    
    
    
}