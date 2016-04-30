<?php
namespace Adminn\Controller;
use Think\Controller;
use Vendor\my\Tree as Tree2;

class AdminController extends BaseController {
	public function index(){
			// { id:0, pId:12, name:"17",open:false},
			// { id:1, pId:0, name:"1", open:true},
			// { id:2, pId:1, name:"2", open:true},
			// { id:3, pId:0, name:"3"}
		// $menu = array(
		// 	array('id'=>0,'pid'=>12,'name'=>'17','open'=>false),
		// 	array('id'=>1,'pid'=>0,'name'=>'1','open'=>true),
		// 	array('id'=>2,'pid'=>1,'name'=>'2','open'=>true),
		// 	array('id'=>3,'pid'=>0,'name'=>3),
		// 	);
		// $this->get_menu1();
		$this->display();
	}
	public function get_menu(){
		// $user = D('user');
		// $res = $user->select();
		// // print_r($res);
		// $json_res = json_encode($res);
		// echo $json_res;
		
		$menu = array(
			array('id'=>0,'pid'=>12,'name'=>'17','open'=>false),
			array('id'=>1,'pid'=>0,'name'=>'1','open'=>true),
			array('id'=>2,'pid'=>1,'name'=>'2','open'=>true),
			array('id'=>3,'pid'=>0,'name'=>3),
			);
		// $menu = json_encode($menu);
		json_rtn(1,$menu);
	}
}