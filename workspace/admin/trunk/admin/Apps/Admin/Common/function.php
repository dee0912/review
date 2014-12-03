<?php

/**
 * URL组装 支持不同URL模式
 * @param string $url URL表达式，格式：'[模块/控制器/操作#锚点@域名]?参数1=值1&参数2=值2...'
 * @param string|array $vars 传入的参数，支持数组和字符串
 * @param string $suffix 伪静态后缀，默认为true表示获取配置值
 * @param boolean $domain 是否显示域名
 * @return string
 */
function UR($url = '', $vars = '', $suffix = true, $domain = false) {
    $url_str = U($url, $vars, $suffix, $domain);
    return str_replace('index.php/', '', $url_str);
}

//提取控制器和方法
function getControlMethodOnly($url) {

    $return_str = str_replace('/index.php/', '', $url);
    $return_str = str_replace('index.php/', '', $return_str);
    $return_str = str_replace('.html', '', $return_str);

    $ary_url = explode('/', $return_str);

    return $ary_url[0] . '/' . $ary_url[1];
}
/**
 * 文件上传到服务器操作方法
 * string $local_filename 要上传的文件名
 * string $file_ext_name 文件后缀名
 * string $meta_list 文件属性详细列表
 * string $group_name storage的组名
 * array $tracker_server  Fast的服务器地址
 * array $storage_server group地址
 * sring return 返回图片url
 */
function fdfs_upload($local_filename,$file_ext_name="jpg",$meta_list="",$group_name="",$tracker_server=array(),$storage_server=array()) {
        //$result = fastdfs_storage_upload_by_filename($local_filename,$file_ext_name,$meta_list,$group_name,$tracker_server,$storage_server);
        $result = fastdfs_storage_upload_by_filename($local_filename,$file_ext_name);
        if($result){
            $group = isset($result["group_name"]) && !empty($result["group_name"]) ? $result["group_name"] : "";
            $filename = isset($result["filename"]) && !empty($result["filename"]) ? $result["filename"] : "";
            if(empty($group) || empty($filename)){
                return array("data"=>"","res"=>-1,"dis"=>"上传失败");exit;
            }
            $link = $group."/".$filename;
            return array("data"=>$link,"res"=>1,"dis"=>"上传成功");exit;
        }
        return array("data"=>"","res"=>-1,"dis"=>"上传失败");exit;
}

