<?php
namespace Admin\Controller;
use Think\Controller;

/*
 * 黑名单级别
 */
class BlackRankController extends Controller{
    
    public function index(){
        $this->assign('search',UR('BlackRank/search'));
        $this->assign('save_url',UR('BlackRank/save'));
        $this->assign('query',UR('BlackRank/query'));
        $this->assign('delete',UR('BlackRank/delete'));
        $this->display();
    }
    
    /*
     * 黑名单级别列表
     */
    public function search(){
        $page=I('page')>0?(int)I('page'):1;
        $page_size=I('page_size')>0?(int)I('page_size'):10;
        
        $rank=M('member_black_rank','',DB_MEMBER);
        
        $rank_count=$rank->field('count(black_rank_id) as nums')->find();
        
        $rank_list=$rank->limit(($page-1)*$page_size,$page_size)->select();
        
        $rank_info['count']=$rank_count['nums'];
        $rank_info['list']=$rank_list;
        echo json_encode($rank_info);
        exit();
    }
    
    
    /*
     * 添加，编辑黑名单级别
     */
    public function save(){
       $rank_name=!empty($_POST['rank_name'])?trim($_POST['rank_name']):'';
       $remark=!empty($_POST['remark'])?trim($_POST['remark']):'';
       $rank_id=I('rank_id')>0?(int)I('rank_id'):0;
      
       if($rank_name==''){
           echo 1;
           exit();
       }
       $rank=M('member_black_rank','',DB_MEMBER);
       
       $now_time=date('Y-m-d H:i:s',time());
       
       $rank_info=array();
       $rank_info['rank_name']=$rank_name;
       $rank_info['remark']=$remark;
       $rank_info['update_time']=$now_time;
       if($rank_id>0){
            $where['black_rank_id']=array('EQ',$rank_id);
            $flag=$rank->where($where)->save($rank_info);
            if($flag){
                echo 4;
                exit();
            }else{
                echo 5;
                exit();
            }
           
       }else{
            $rank_info['add_time']=$now_time;
            $flag=$rank->data($rank_info)->add();
            if($flag>0){
                echo 2;
                exit();
            }else{
                echo 3;
                exit();
            }
       }
    }
    
    /*
     * 查询黑名单级别
     */
    public function query(){
        $rank_id=I('black_rank_id')>0?(int)I('black_rank_id'):0;
        if($rank_id==0){
            echo 1;
            exit();
        }
        $rank=M('member_black_rank','',DB_MEMBER);
        $where['black_rank_id']=array('EQ',$rank_id);
        $rank_info=$rank->field('rank_name,remark')->where($where)->find();
        echo json_encode($rank_info);
        exit();
    }
    
    /*
     * 删除黑名单级别
     */
    public function delete(){
        $rank_id=I('rank_id')>0?(int)I('rank_id'):0;
        if($rank_id==0){
            echo 1;
            exit();
        }
        
        $where['black_rank_id']=array('eq',$rank_id);
        //删除此级别的黑名单会员
        $black=M('member_black','',DB_MEMBER); 
        $black->where($where)->delete();
        
        $rank=M('member_black_rank','',DB_MEMBER);
        $flag=$rank->where($where)->delete();
        if($flag){
            echo 2;
        }else{
            echo 3;
        }        
    }
}
