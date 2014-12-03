<?php

namespace Admin\Controller;

use Think\Controller;
use Admin\Common\SessionHelper;

class LoginController extends Controller {

    private $host = "ldap://172.16.10.206"; //ldap://pek1-dcs-02";//ldap服务器地址
    private $port = "389"; //ldap访问端口
    private $name_prefix = 'chunbo\\'; //'CHUNBO\\';//后台用户名前缀

    /*
     * 后台用户登陆
     */

    public function index() {
        $this->assign('url', UR('Login/login'));
        

            
        
        $this->display();
    }

    /*
     * 后台用户ldap登陆验证，同步用户
     */

    public function login() {

        $user_name = !empty($_POST['user_name']) ? trim($_POST['user_name']) : '';
        $pwd = !empty($_POST['pwd']) ? trim($_POST['pwd']) : '';

        if ($user_name == '' || $pwd == '') {
            $this->error('用户名/密码不能为空');
        }

        $conn = ldap_connect($this->host, $this->port);

        $flag = ldap_bind($conn, $this->name_prefix . $user_name, $pwd);

        if ($flag) {
            $this->user_verify($user_name);

            //$this->success('登陆成功', UR('Index/index'));
            redirect("/Index/index");
        } else {
            $this->error('登陆失败');
        }
    }

    public function getToken() {
        $token = I("token");

        echo $token;
    }

    public function quit() {
        SessionHelper::del("permission");
        
        session(null);

        redirect(C("LOGIN_URL"));
    }

    /*
     * 校验用户是否存在，添加用户
     */

    public function user_verify($user_name) {
        $user = M('admin_user', '', DB_ADMIN);
        $user_info = $user->field('user_id,status')->where("user_name='" . $user_name . "'")->find();
        $now_time = time();
        if (!$user_info) {
            $data['user_name'] = $user_name;
            $data['status'] = 1;
            $data['last_time'] = $now_time;
            $data['add_time'] = $now_time;
            $user_id = $user->add($data);
        } elseif ($user_info['status'] == 2) {
            $this->error('您的账号已锁定,请联系管理员给您开启');
        } else {
            $data['last_time'] = time();
            $user->where('user_id=' . $user_info['user_id'])->save($data);
            $user_id = $user_info['user_id'];
        }

        session('user_id', $user_id);
        session('user_name', $user_name);
    }

}
