<?php
/**
 * ThinkPHP 应用程序类 执行应用过程管理
 */
namespace Think;
class Api {
    protected static $timeout = 1;
    protected static $retry = 1;
    protected static $is_return_str = false;//是否返回json字符串
    /**
     * string $url 请求url
     * array  $param  请求参数
     * string $type  请求类型默认get请求 
     */
    static public function request($url,$param=array(),$type="get"){
        $result = Api::curlGet($url,$param,$type,self::$timeout,self::$retry,self::$is_return_str);
        return $result;
    }
    
    static public function request_json($url,$param=array(),$type="get"){
        $result = Api::curlGet($url,$param,$type,self::$timeout,self::$retry,TRUE);
        return $result;
    }
    
    static function curlGet($url,$param,$type,$timeout, $retry,$is_json){
        $result_array = array();
        $retry = $retry>1?$retry:1;
        for ($i = 0; $i < $retry; $i++) {
            $ch = curl_init();
            if($type == "get"){
                foreach($param as $key=>$value){
                    $url.="/".$key."/".$value;
                }
            }
            $options = array(CURLOPT_URL => $url,
                CURLOPT_HEADER => FALSE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_CONNECTTIMEOUT => 1,
                CURLOPT_DNS_CACHE_TIMEOUT => 1,
                CURLOPT_TIMEOUT => $timeout);
            switch ($type){
                case "post":Api::is_post($ch,$options,$param); break;  
                case "get":curl_setopt_array($ch, $options);  break;
                default:curl_setopt_array($ch, $options);
            }
            
            $request_json =  curl_exec($ch);
            if($is_json)
            {//如果需要的字符串，直接返回即可
                curl_close($ch);
                return $is_json;
            }
            else{
                $result_array["res"] = $request_json;
            }

            $errorno = curl_errno($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($errorno != 0) {
                $result_array['error'] = curl_error($ch);
            } else if ($http_code != 200) {
                $result_array['error'] = "CODE: ".$http_code;
            } else {
                curl_close($ch);
                break;
            }
            curl_close($ch);
        }
        if ($http_code == 200 AND false != $result_array["res"]) {//OK
            $result_array["res"] = json_decode($result_array["res"],true);
        } else {
            $result_array["res"] = "";
        }
        return $result_array;
    }
    //post请求设置
    static public function is_post($ch,$options,$post_data){
        curl_setopt_array($ch,$options);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }
    
}

?>
