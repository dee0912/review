<?php

namespace Admin\Controller;

use Think\Controller;
use Admin\Common\SessionHelper;

class BaseController extends Controller {

    public static $permission;
    public static $version;

    function __construct() {

        parent::__construct();

        //验证
        self::checkInput();

        self::$version = C("VERSION");
    }

    public function getIsLogin() {

        redirect(C("SSO_SITE_URL") . "Login/isLogin?return_url=http://" . $_SERVER['HTTP_HOST'] . str_replace('/index.php', '', $_SERVER['PHP_SELF']));
    }

    public function getPermissionList($token) {
        $systemt_code_name = "ops"; //admin系统就是 运营系统

        $table = M('', '', 'DB_PERMISSION');
        $select_sql = "SELECT secret_key FROM system WHERE code_name='" . $systemt_code_name . "'";
        $secret_info = $table->query($select_sql);
        if ($secret_info) {
            $secret_key = $secret_info[0]["secret_key"];
            $tmpArry = array($systemt_code_name, $token, $secret_key);
            sort($tmpArry, SORT_STRING);
            $sign = md5(implode($tmpArry));

            $return_permiession_json_str = file_get_contents(C("SSO_SITE_URL") . "Login/validate?system_code_name=$systemt_code_name&token=$token&sign=$sign");

            $permission_list = json_decode($return_permiession_json_str, true);

            $return_perm = array();
            foreach ($permission_list as $perm) {//提取当前页面需要的数据
                $pos = strpos($perm["url"], getControlMethodOnly($_SERVER['PHP_SELF']));

                if ($pos !== false) {//说明存在
                    $return_perm[] = $perm;
                }
            }

            if (count($return_perm) == 0) {
                exit("没有权限访问");
            }

            self::$permission = json_encode($return_perm);

            SessionHelper::set("permission", self::$permission);
        }
    }

    public function checkInput() {
        $token = I("token");
        $permission = I("permission");
        //取得url
        $current_control_method = getControlMethodOnly($_SERVER['PHP_SELF']);
        //当前的权限
        $current_permission = json_decode(SessionHelper::get("permission"), true);

        //对角色的方法进行过滤
        if (count($current_permission) > 0) {

            return;

            //判断方法
//            $pos = strpos($current_permission[0]["addition"], $current_control_method);
//
//            if ($pos !== false) {//说明存在      
            //return;
//            }
        }

        //通过过滤方式,get的全部通过
//            $current_method = explode("/", $current_control_method)[1];
//            if (substr($current_method, 0, 3) == 'get')
//                return;


        if (strlen($token) <= 0) {
            self::getIsLogin();
        } else {
            self::getPermissionList($token);
        }
    }

    public function logDebug($msg, $func_name = '') {
        $log = new \Admin\BLL\AdminLogs();
        $log->debug($msg, $func_name);
    }

    public function logError($msg, $func_name = '') {
        $log = new \Admin\BLL\AdminLogs();
        $log->error($msg, $func_name);
    }

}
