<?php
namespace Admin\Controller;
use Think\Controller;

/*
 * 黑名单管理
 */
class BlackListController extends Controller{
    
    public function index(){
        $this->assign('search',UR('BlackList/search'));
        $this->assign('save',UR('BlackList/save'));
        $this->assign('query',UR('BlackList/query'));
        $this->assign('edit',UR('BlackList/edit'));
        $this->assign('delete',UR('BlackList/delete'));
        
        //获取黑名单级别列表
        $black_rank=M('member_black_rank','',DB_MEMBER);
        $rank_list=$black_rank->field('black_rank_id,rank_name')->select();
        $this->assign('rank_list',$rank_list);
        $this->display();
    }
    
    /*
     * 获取黑名单列表
     */
    public function search(){
        $page=I('page')>0?(int)I('page'):1;
        $page_size=I('page_size')?(int)I('page_size'):10;
        
        $start_date=!empty($_POST['start_date'])?trim($_POST['start_date']):'';
        $end_date=!empty($_POST['end_date'])?trim($_POST['end_date']):'';
        $member_id=I('member_id')>0?(int)I('member_id'):0;
        $nickname=!empty($_POST['nickname'])?trim($_POST['nickname']):'';
        $mobile=!empty($_POST['mobile'])?trim($_POST['mobile']):'';
        
        $member_where=array();
        $where=array();
        if($mobile!=''){
            $member_where['mobile']=array('EQ',$mobile);
        }
        if($nickname){
            $member_where['nickname']=array('LIKE',$nickname);
        }
        if(isset($member_where['nickname']) || isset($member_where['mobile'])){
            $memberObj=M('member_info','',DB_MEMBER);
            $member_list=$memberObj->where($member_where)->getField('member_id',true);
            if(count($member_list)>0){
                $where['member_id'][]=array('IN',  implode(',', $member_list));
            }
        }
        
        if($member_id>0){
            $where['member_id'][]=array('EQ',$member_id);
        }
        if(!empty($start_date) && !empty($end_date)){
            $where['add_time']=array(
                array('EGT',$start_date),
                array('ELT',$end_date),
            );
        }
        
        
        
        $black=M('member_black','',DB_MEMBER);
        $nums=$black->field('count(black_id) as num')->where($where)->find();
        
        $info=$black->limit(($page-1)*$page_size,$page_size)->where($where)->select();

        $rank=M('member_black_rank','',DB_MEMBER);
        $member=M('member_info','',DB_MEMBER);
        foreach($info as $key=>$val){
            $member_info=$member->field('nickname,mobile')->where('member_id='.$val['member_id'])->find();
            $info[$key]['nickname']=$member_info['nickname'];
            $info[$key]['mobile']=$member_info['mobile'];
            $rank_info=$rank->field('rank_name')->where('black_rank_id='.$val['black_rank_id'])->find();
            $info[$key]['rank_name']=$rank_info['rank_name'];            
        }
        $black_list=array();
        $black_list['count']=$nums['num'];
        $black_list['list']=$info;
        echo json_encode($black_list);        
    }
    
    
    /*
     * 添加，修改黑名单
     */
    public function save(){
        $member_info=!empty($_POST['member_info'])?trim($_POST['member_info']):'';
        $rank_id=I('rank_id')>0?(int)I('rank_id'):0;
        $remark=I('remark');
        
        if($member_info=='' || $rank_id==0){
            echo 1;
            exit();
        }
        
        if(substr_count($member_info,',')){
            $member_list=  explode(',', $member_info);
        }else{
            $member_list[]=$member_info;
        }
        
        $member=M('member_info','',DB_MEMBER);
        $res=$member->field('count(member_id) as nums')->where("status=2 AND member_id IN (".$member_info.") OR mobile IN (".$member_info.")")->find();
        if($res['nums']>0){
            echo 2;
            exit();
        }
        
        $m=new \Think\Model('','',DB_MEMBER);
        $m->startTrans();//开启事务
        $save_info['status']=2;
        $member_flag=$m->table('member_info')->where("status=1 AND member_id IN (".$member_info.") OR mobile IN (".$member_info.")")->save($save_info);       

        $now_time=date('Y-m-d H:i:s',time());
        $black_list=array();
        foreach($member_list as $val){
            $member_id=$m->table('member_info')->field('member_id')->where('member_id='.$val.' OR mobile='.$val)->find();
            if($member_id['member_id']>0){
                $rows['member_id']=$member_id['member_id'];
                $rows['black_rank_id']=$rank_id;
                $rows['remark']=$remark;
                $rows['update_time']=$now_time;
                $rows['add_time']=$now_time;
                $black_list[]=$rows;
            }
        }
        
        if(count($black_list)>0){
            $black_flag=$m->table('member_black')->addAll($black_list);
        }else{
            $black_flag=FALSE;
        }
        
        if($black_flag && $member_flag){
            $m->commit();
            echo 3;
        }else{
            $m->rollback();
            echo 4;            
        }        
    }
    
    //编辑黑名单查询
    public function query(){
        $black_id=I('black_id')>0?(int)I('black_id'):0;
        if($black_id==0){
            echo 1;
            exit();
        }
        
        $blackObj=M('member_black','',DB_MEMBER);
        $black_info=$blackObj->field('member_black.member_id,member_black.black_rank_id,member_black.remark,member_info.nickname,member_info.mobile')
                ->join('member_info ON member_info.member_id=member_black.member_id')
                ->where('member_black.black_id='.$black_id)->find();
                
        echo json_encode($black_info);
    }
    //编辑黑名单操作
    public function edit(){
        $black_id=I('black_id')>0?(int)I('black_id'):0;
        $rank_id=I('rank_id')>0?(int)I('rank_id'):0;
        $remark=trim($_POST['remark']);
        
        if($black_id==0 || $rank_id ==0){
            echo 1;
            exit();
        }
        $blackObj=M('member_black','',DB_MEMBER);
        $res['black_rank_id']=$rank_id;
        $res['remark']=$remark;
        $res['update_time']=date('Y-m-d H:i:s',time());
        $flag=$blackObj->where('black_id='.$black_id)->save($res);
        if($flag){
            echo 2;            
        }else{
            echo 3;
        }
    }
    
    //删除黑名单操作
    public function delete(){
         $black_id=I('black_id')>0?(int)I('black_id'):0;
         $member_id=I('member_id')>0?(int)I('member_id'):0;
         if($black_id==0 || $member_id==0){
             echo 1;
             exit();
         }
        
        $m=new \Think\Model('','',DB_MEMBER);
        $m->startTrans();//开启事务
        $member_info['status']=1;
        $m_flag=$m->table('member_info')->where('member_id='.$member_id)->save($member_info);
        $b_flag=$m->table('member_black')->where('member_id='.$member_id.' AND black_id='.$black_id)->delete();
       
        if($m_flag && $b_flag){
            $m->commit();
            echo 2;
        }else{
            $m->rollback();
            echo 3;
        }
    }
}

