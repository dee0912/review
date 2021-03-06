<?php

namespace Admin\Controller;

use Think\Controller;
use Think\Api;

class CmsController extends Controller {
    private $api_url = "http://chenkuanxin.cms.com";
    public function searchPage(){
        $url = $this->api_url."/Cms/indexPage";
        $param = array();
        if(I("param.")){
            $param = array();
            if(session("cms_search_page")){
               $param = array_merge(session("cms_search_page"),I("param."));
            }else{
               $param = I("param.");
               session("cms_search_page",$param); 
            }
            foreach($param as $key=>$val){
                if($val == ""){
                    unset($param[$key]);
                }
            }
            $param = !empty($param) ? $param : array();
            $pagelist = Api::request($url,$param);
            $this->assign("searchVal",$param);
        }else{
            session('cms_search_page',null);
            $pagelist = Api::request($url);
        }
        if($pagelist["res"]["data"]){
            $Page = new \Think\Page($pagelist["res"]["count"],3);
            $show = $Page->show();
            $this->assign('page',$show);
        }        
        $this->assign("pagelist",$pagelist["res"]);
        $this->display();                
    }
    public function addPage(){
        if(I("param.")){
            $url = $this->api_url."/Cms/addPage";
            $result = Api::request($url,I("param."),"post");
            echo json_encode($result);exit;
        }        
        $this->display();               
    }
    //编辑page页
    public function modifyPage(){
        if(I("param.dotype")){
            $url = $this->api_url."/Cms/indexPageDetail";
            $pagelist = Api::request($url,array("page_id"=>I("param.page_id")));
            if($pagelist["res"]["result"] == 1){
                $this->assign("data",$pagelist["res"]["data"]);
                $this->show();
            }   
        }else{
            $url = $this->api_url."/Cms/editPage";
            $result = Api::request($url,I("param."));
            echo json_encode($result);exit;
        }                       
    }
    public function deletePage(){
        $url = $this->api_url."/Cms/delPage";
        $result = Api::request($url,I("param."));
        echo json_encode($result);exit;
    }
}
	
