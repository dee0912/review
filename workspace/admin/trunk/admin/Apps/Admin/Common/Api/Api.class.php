<?php
/**
 * ThinkPHP 应用程序类 执行应用过程管理
 */
namespace Admin\Common\Api;
class Api {
    protected static $timeout = 1;
    private static $data_array;
    /**
     * $url_array (string | array) 请求的url
     * $param （array） 请求的参数
     * $type (string) 请求类型 （默认 get）
     */
    static public function request($url_list,$param=array(),$type="get"){
        $result = Api::curlGet($url_list,$param,$type,self::$timeout);
        return $result;
    }
    static function doarray($url_list,$param,$type){
        if(is_array($url_list)){
            if($type == "get"){
                foreach($url_list as $key=>$val){
                     foreach($param[$key] as $k=>$v){
                         $val.="/".$k."/".$v;
                     }
                     self::$data_array[$key]["url"] = $val;
                }                
            }else{
               foreach($url_list as $key=>$val){
                     self::$data_array[$key]["url"] = $val;
                     self::$data_array[$key]["data"] = $param[$key];
                }
            }                
        }else{
            if($type == "get"){
                if($param){
                    foreach($param as $key=>$value){
                        $url_list.="/".$key."/".$value;
                    }
                }
                self::$data_array[]["url"] = $url_list;
            }else{
                $data["url"] = $url_list;
                $data["data"] = $param;
                self::$data_array[] = $data;
           }
        }
    }
    static function curlGet($url_list,$param,$type,$timeout){
        Api::doarray($url_list,$param,$type);
        $url_list = array();
        $result_array = array();
        $multi_ch = curl_multi_init();
        foreach(self::$data_array as $key=>$request){
            $ch = curl_init();
            $options = array(CURLOPT_URL => $request["url"],
                CURLOPT_HEADER => FALSE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_CONNECTTIMEOUT => 1,
                CURLOPT_DNS_CACHE_TIMEOUT => 1,
                CURLOPT_TIMEOUT => $timeout);
            switch ($type){
                case "post":Api::is_post($ch,$options,$request["data"]); break;  
                case "get":curl_setopt_array($ch, $options);  break;
                default:curl_setopt_array($ch, $options);
            }
            curl_multi_add_handle($multi_ch, $ch);
            $result_array[$key] = $ch;
        }
        do {
            curl_multi_exec($multi_ch, $running);
        } while ($running > 0);
        $result = array();
        foreach($result_array as $key=>$ch){
            $data = curl_multi_getcontent($ch);
            $errorno = curl_errno($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($errorno != 0) {
                $result[$key]['error'] = curl_error($ch);
            } else if ($http_code != 200) {
                $result[$key]['error'] = "CODE: ".$http_code;
            }
            if ($http_code == 200 AND false != $data) {//OK
                  $result[$key] = json_decode($data,true);
            } else {
                $result[$key] = "";
            }
        }
        curl_close($ch);
        return $result;
    }
    static public function is_post($ch,$options,$post_data){
        curl_setopt_array($ch,$options);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }
    
}

?>
