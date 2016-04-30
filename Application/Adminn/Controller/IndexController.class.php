<?php
namespace Adminn\Controller;
use Think\Controller;
class IndexController extends BaseController {
	// public function _initialize(){

	// 	dump(cookie('adminAuth'));
	// 	exit('test');
	// }
    public function index(){
    	// $this->assign('title','爱游思后台管理');
     //    $this->display();
    	if(LOGIN_ADMIN){
    		header('location:'.U('admin/index'));
    		exit();
    	}
    	header('location:'.U('Login/index'));
    	exit();
    }

}