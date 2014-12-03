<?php
namespace Admin\Model;
use Think\Model;

class MemberModel extends Model{
    protected $dbName='member';
    protected $trueTableName='member_info';
    
    
    /*
     * 查询会员列表
     * parameter
     *      page:当前页
     *      page_size:每页条数
     *      where:查询条件
     */
    public function member_list($page,$page_size,$where){
        $member_field=array('member_id','member_name','nickname','points','money','status','last_time','reg_time');//查询字段
        
        $nums=$this->field('count(member_id) as nums')->where($where)->find();

        
        $list=$this->field($member_field)->where($where)->limit(($page-1)*$page_size,$page_size)->select();       
       
        
        $res['count']=$nums['nums'];
        $res['list']=$list;
        return $res;
        
    }
    
    public function edit_pwd($member_id){
        $pwd=  $this->randomkeys();
        
        $data['password']=md5($pwd);
        $flag=  $this->where('member_id='.$member_id)->save($data);
        if($flag){
            return $pwd;
        }else{
            return false;
        }
        
    }
    
    private function randomkeys($length=6){
        $pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';        
        for($i=0;$i<$length;$i++)
        {
          $key .= $pattern{mt_rand(0,35)};//生成php随机数
        }
        return $key;
    }
}

