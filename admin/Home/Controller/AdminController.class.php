<?php
namespace Home\Controller;
use Think\Controller;

class AdminController extends Controller{


	public function getList(){

		$url = "http://admin.huangdi.com/index.php/Home/Review/searchReview/";
		$handle = fopen($url,"rb");
		$content = "";
		while(!feof($handle)){
		
			$content .= fread($handle,10000);
		}
		fclose($handel);
		
		$content = json_decode($content,true);
		
/*		//每页记录数
		$perpage = 5;
		
		//分页
		$Page       = new \Think\Page($content['count'],$perpage);			// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();								// 分页显示输出	*/
		
		$this->assign("count",$content['count']);
		$this->assign("list",$content['list']);
		$this->assign("show",$content['show']);
		$this->display();
		
	}
	

}