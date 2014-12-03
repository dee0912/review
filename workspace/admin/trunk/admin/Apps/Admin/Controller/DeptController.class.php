<?php
namespace Admin\Controller;
use Think\Controller;

class DeptController extends Controller{
    public function index(){
        $this->assign('save_url',UR('Dept/save'));
        $this->assign('search_url',UR('Dept/search'));
        $this->assign('query_url',UR('Dept/query_dept'));
        $this->assign('del_url',UR('Dept/del_dept'));
        $this->display();
    }
    
    /*
     * 添加修改部门
     */
    public function save(){
        $department_name=!empty($_POST['name'])?trim(I('name')):'';
        $status=(int)I('status');
        $dept_id=(int)I('dept_id');
        
    if($department_name == '' || ($status!=1 && $status!=2)){
            echo 1;
            exit();
        }
        
        $deptObj=M('admin_department');        
        $dept_info=array();
        $dept_info['department_name']=$department_name;
        $dept_info['status']=$status;
        $dept_flag=$deptObj->field('department_id')->where('department_name='.$department_name)->find();
        
        $now_time=date('Y-m-d H:i:s',time());
        if(!$dept_flag && $dept_id==0){
            //添加部门
            $dept_info['add_time']=$now_time;
            $dept_info['update_time']=$now_time;
            $dept_id=$deptObj->add($dept_info);
            if($dept_id>0){
                echo 2;
            }else{
                echo 3;
            }            
        }else{
            //编辑部门
             $dept_info['update_time']=$now_time;
             $nums=$deptObj->where('department_id='.$dept_id)->save($dept_info);
             if($nums>0){
                 echo 4;
             }else{
                 echo 5;
             }
        }
    }
    
    /*
     * 搜索部门
     */
    public function search(){
        $deptObj=M('admin_department');
        $page=I('page')>0?(int)I('page'):1;
        $page_num=20;
        
        $dept_page_count=$deptObj->field('count(*) as nums')->find();
        
        $dept_list=$deptObj->limit($page-1,$page_num)->order('update_time desc')->select();
        foreach ($dept_list as $key=>$val){          
            $dept_list[$key]['status']=$val['status']==1?'开启':'关闭';
        }
        $dept_info['count']=$dept_page_count['nums'];
        $dept_info['list']=$dept_list;
        $dept_info['page']=$page;
        echo json_encode($dept_info);
    }
    
    /*
     * 查询部门
     */
    public function query_dept(){
        $department_id=I('dept_id')>0?(int)I('dept_id'):0;
        if($department_id==0){
            echo 1;
        }else{
            $deptObj=M('admin_department');
            $dept_info=$deptObj->field('department_id,department_name,status')->where('department_id='.$department_id)->find();
            echo json_encode($dept_info);
        }
    }
    
    /*
     * 删除部门
     */
    public function del_dept(){
         $department_id=I('dept_id')>0?(int)I('dept_id'):0;
         if($department_id==0){
            echo 1;
        }else{
            $mapObj=M('admin_department_map');
            $num=$mapObj->where('department_id='.$department_id)->delete();
          
            $deptObj=M('admin_department');
            $dept_num=$deptObj->where('department_id='.$department_id)->delete();
            if($dept_num>0){
                echo 2;
            }else{
                echo 3;
            }
        }
    }
}

