<?php
namespace Admin\Controller;

class IndexController extends BaseController {

    public function index() {
 
        redirect(C("SSO_SITE_URL"));
        
        //$this->display();
    }

    public function top() {
        $this->display();
    }
    
    public function left() {
        $this->display();
    }
    
    
    
}
