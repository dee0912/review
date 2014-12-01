<?php 
namespace Admin\Controller;
use Admin\Common\Api\Api;
/*
 * 会员余额列表
 */
class BalanceController extends BaseController{
	//查看会员积分列表
	function index(){
		$map['member_id']=(int)I('member_id');
		$map['operation_type']=I('operation_type')?(int)I('operation_type'):3;
		$map['page']=I('page')?(int)I('page'):1;
		$map['page_size']=I('page_size')?(int)I('page_size'):10;
		
		$list=$this->lists($map);
		$this->assign('list',$list['list']);
		$this->assign('balance',$this->balanceCount(I('member_id')));
		$this->assign('operation_type',$map['operation_type']);

		$Page=new \Think\Page($list['count'],$map['page_size']);
		$this->assign('page',$Page->show());
		$this->display();
	}
        //获取会员积分列表
	private function lists($data){
            $url=UR('Balance/gets@'.C('MEMBER_URL'));
            $result=  Api::request($url,$data, "post");
            $resultArr=$result[0];
            if($resultArr['flag']==2){		//出错了
            	$info['list']=NULL;	
            }else{
            	$info['list']=$resultArr['balance_list'];		//显示数据
            }
            $info['balance']=$resultArr['balance'];
            $info['count']=$resultArr['count'];
            return $info;
	}
        //获取余额总值
	private function balanceCount($member_id){
            $url=UR('Balance/balanceCount@'.C('MEMBER_URL'));
            $data['member_id']=$member_id;
            $result=  Api::request($url,$data,"post");            
            $resultArr=$result[0];
            return $resultArr['balance'];
	}
}