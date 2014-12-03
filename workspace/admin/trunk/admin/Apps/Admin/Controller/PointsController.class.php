<?php 
namespace Admin\Controller;
use Admin\Common\Api\Api;
/*
 * 积分列表
 */

class PointsController extends BaseController{
	//查看会员积分列表
	public function index(){
            $map['member_id']=(int)I('member_id');
            $map['operation_type']=I('operation_type')?(int)I('operation_type'):3;
            $map['page']=I('page')?(int)I('page'):1;
            $map['page_size']=I('page_size')?(int)I('page_size'):10;
            
            if($map['member_id']==0){
                $this->display();
                exit();
            }
            
            $data=$this->lists($map);

            $this->assign('operation_type',$map['operation_type']);
            $this->assign('list',$data['data']);
            $this->assign('points',$this->getPointsTotal(I('member_id')));
            $this->assign('expiry_points',$this->expiryPoint(I('member_id')));
		
            $Page=new \Think\Page($data['count'],$map['page_size']);
            $this->assign('page',$Page->show());
            $this->display();
	}
	/**
	 * 获取积分列表
	 */
	private function lists($data){
            $url=UR('Points/gets@'.C('MEMBER_URL'));
            $result=Api::request($url,$data,'post');          
            $resultArr=$result[0];
            if($resultArr['flag']==2){//出错了
		$list['data']=NULL;
            }else{
		$list['data']=$resultArr['points_list'];//显示数据
            }
            $list['points']=$resultArr['points'];
            $list['expiry_points']=$resultArr['expiry_points'];
            $list['count']=$resultArr['count'];
            return $list;
	}

	/**
	 * 获取总积分
	 */
	private function getPointsTotal($member_id){
            $url=UR("Points/getPointsTotal@".C('MEMBER_URL'));           
            $data['member_id']=$member_id;
            $result= Api::request($url,$data,"post");            
            $resultArr=$result[0];
            return $resultArr['pointsTotal'];
	}
        /*
         * 获取过期积分
         */
	private function expiryPoint($member_id){
            $url=UR("Points/expiryPoint@".C('MEMBER_URL'));           
            $data['member_id']=$member_id;
            $result=  Api::request($url,$data, "post");            
            $resultArr=$result[0];
            return $resultArr['points'];
	}

}