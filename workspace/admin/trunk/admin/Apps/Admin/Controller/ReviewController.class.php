<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Api\Api;

class ReviewController extends Controller{

    private $api_url = "http://review.huangdi.com/";
    private $tag_url = "http://chenkuanxin.catalog.com/";

    //获取后台评论列表
    public function getList(){

        //每页记录数
        $perpage = 5;
        //当前页
        $page = $_GET['page'] == ""?1:$_GET['page'];
        $pageInfo = "perpage/".$perpage."/page/".$page."/";

        if(!$_GET['submit']){  //列出所有评论

            //$url = $this->api_url."Review/searchReview/".$pageInfo;
            $url_list = array(
                
                "list" => $this->api_url."/Review/searchReview/".$param.$pageInfo, //请求评论列表
                "tagtype" => $this->tag_url."Tag/getTagType",                      //请求标签类型
                "taglist" => $this->tag_url."Tag/searchTagList/",               //请求标签类型下相应列表
            );   
            
            //$res = Api::request($url);
            $res = Api::request($url_list);
            //print_r($res);
        }else{  //查询评论

            $param = "";
            if($_GET['start_date'] != "" && $_GET['end_date'] != ""){

                $param .= "start_date/".$_GET['start_date']."/end_date/".$_GET['end_date']."/"; 
            }

            if($_GET['product_id'] != ""){

                $param .= "product_id/".$_GET['product_id']."/";
            }

            if($_GET['order_id'] != ""){

                $param .= "order_id/".$_GET['order_id']."/";
            }

            //$url = $this->api_url."/Review/searchReview/".$param.$pageInfo;        
            //$res = Api::request($url,$param);
            $url_list = array(
                
                "list" => $this->api_url."/Review/searchReview/".$param.$pageInfo, //请求评论列表
                "tagtype" => $this->tag_url."Tag/getTagType",   //请求标签类型
            );   
      //print_r($this->api_url."/Review/searchReview/".$param.$pageInfo);exit();      
            $res = Api::request($url_list);
           
        }
        //print_r($res);exit();
        //分页
        $P       = new \Think\Page($res['list']['count'],$perpage);      // 实例化分页类 传入总记录数和每页显示的记录数
 
        if($param){

            foreach($param as $key=>$val){
            
                 $P->parameter   .=   "$key/".urlencode($val).'/';

            }
        }
        
        $show       = $P->show();                                    // 分页显示输出	

        $this->assign("count",$res['list']['count']);
        $this->assign("list",$res['list']['list']);
        $this->assign("tagType",$res['tagtype']);
        $this->assign("tagList",$res['taglist']['data']);
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
         $review_user = I("review_user");
         $member_id = I("member_id");

         $comment = I("comment");
         $score = I("score");
         $tag_name = I("tag_name");
         $sale_prop = I("sale_prop");
         
         $priority = I("priority");
    
         //标签type固定 tag_name1,tag_name2,tag_name3,tag_name4
         $tag_name[] = $tag_name1 = I("tag_name1"); 
         $tag_name[] = $tag_name2 = I("tag_name2");
         $tag_name[] = $tag_name3 = I("tag_name3");
         $tag_name[] = $tag_name4 = I("tag_name4");
         
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

         $param = array(

            "product_id" => $product_id,
            "order_id" => $order_id,
            "review_user" => $review_user,
            "member_id" => $member_id,

            "comment" => $comment,
            "score" => $score,
            "tag_name" => $tag_name,
            "sale_prop" => $sale_prop,
             
            "priority" => $priority,
             
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
        
    //管理员评论
    public function setReply(){

        $reply = I("reply");
        $review_id = I("re_review_id");
        $param = array(
            "reply"=>$reply,
            "review_id"=>$review_id
        );           
        $url = $this->api_url."Review/reply";
        $type = "post";

        $res = Api::request($url,$param,$type);
//print_r($res);exit();
        if($res[0]['flag'] == 1){

             echo "回复成功";
        }else if($res[0]['flag'] == 0){

             echo "回复失败";
        }else if($res[0]['error'] == 1){
            
            echo "管理员评论为空";
        }else if($res[0]['error'] == 2){
            
            echo "用户评论不存在";
        }                   
    }

    
    
    
    
    
    
    
    
}