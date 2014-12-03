<?php
namespace Admin\Controller;
use Admin\Common\Api\Api;

/*
 * 会员列表
 */
class MemberController extends BaseController{
    
    public function index(){
        $this->assign('balance',UR('Balance/index/member_id','',''));
        $this->assign('points',UR('Points/index/member_id','',''));
        $this->assign('search',UR('Member/search'));
        $this->assign('edit',UR('Member/edit'));
        $this->assign('query',UR('Member/query'));
        $this->assign('show_addrs',UR('Member/showAddrs/member_id','',''));
        $this->display();
    }
    /*
     * 查询会员详情
     */
    public function query(){
        $member_id=(int)I('member_id');
        if($member_id==0){
            echo 1;
            exit();
        }
        $param['member_id']=$member_id;
        $url=UR('Member/Get@'.C('MEMBER_URL'));
        $result=Api::request($url,$param,'post');     
        echo json_encode($result[0]);
    }
    /*
     * 查询会员列表
     */    
    public function search(){
        $param['page']=I('page')>0?(int)I('page'):1;
        $param['page_size']=I('page_size')>0?(int)I('page_size'):10;
        $param['nickname']=I('nickname')?trim(I('nickname')):'';
        $param['member_id']=I('member_id')>0?(int)I('member_id'):0;
        $param['is_on_blanklist']=(int)I('status');
        $param['start_date']=I('start_date')?trim(I('start_date')):'';
        $param['end_date']=I('end_date')?trim(I('end_date')):'';
        
        $url=UR('Member/GetList@'.C('MEMBER_URL')); 
        $resutlt=Api::request($url,$param,'post');
        $member_info=$resutlt[0];
        foreach($member_info['member_list'] as $key=>$value){
            $param['member_id']=$value['member_id'];            
            $url=UR('Address/GetNums@'.C('MEMBER_URL'));
            $addrs=Api::request($url,$param,'post');            
            $member_info['member_list'][$key]['addrs_num']=$addrs[0]['nums'];
            
            $param['favorite_type']=1;            
            $url=UR('Favorite/GetNums@'.C('MEMBER_URL'));
            $fav=Api::request($url,$param,'post');
            $member_info['member_list'][$key]['favorite_product_nums']=$fav[0]['nums']; 
            $param['favorite_type']=2;
            
            $fav=Api::request($url,$param,'post');
            $member_info['member_list'][$key]['favorite_cookbook_nums']=$fav[0]['nums']; 
        }        
        echo json_encode($member_info);
    }
    
    /*
     * 修改密码
     */
    public function edit(){
        $login_id=(int)I('login_id');
        if($login_id==0){
            echo 1;//操作失败
            exit();
        }
        $pwd='123456';
        $param['login_id']=$login_id;
        $param['password']=md5($pwd);
        $url=UR('Member/ChangePass@'.C('MEMBER_URL'));      
        $result=Api::request($url,$param,'post');        
        $res=$result['res'];
        if($res['flag']==1){
            echo $pwd;
        }else{
            if($res['erorn']==4019){
                echo 1;                
            }else{
                echo 2;
            }
        }
    }
    
    /*
     * 查询会员收货地址
     */
    public function showAddrs(){
        $param['member_id']=(int)I('member_id');
        $param['page']=I('page')>0?(int)I('page'):1;
        $param['page_size']=I('page_size')>0?(int)I('page_size'):10;
        if($param['member_id']==0){
            $this->error('请选择要操作会员');      
        }
        $url=UR('Address/GetList@'.C('MEMBER_URL'));
        $result=Api::request($url, $param, 'post');    
        $addrs_list=$result[0];
        $Page=new \Think\Page($addrs_list['count'],$param['page_size']);
        $this->assign('page',$Page->show());
        $this->assign('list',$addrs_list);
        $this->display();
    }
}
