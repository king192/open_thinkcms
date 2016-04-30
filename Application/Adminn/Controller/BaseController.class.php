<?php
namespace Adminn\Controller;
use Think\Controller;
use Vendor\my\Tree as Tree2;

class BaseController extends Controller {
	protected $Menu;
	protected $cate = array();
	public function _initialize(){
		define('LOGIN_ADMIN', is_admin_login());
		// dump(LOGIN_ADMIN);
		// exit;
		// 验证是否登陆
		if(!LOGIN_ADMIN){
			header('location:'.U('Login/index'));
			exit('you are not login!');
		}
		// dump(LOGIN_ADMIN);
		//验证是否有权限
		if(LOGIN_ADMIN !== '1'){
			if(!check_access(LOGIN_ADMIN)){
				if($_SERVER['REQUEST_METHOD']=='POST'){
					json_rtn(-999,'您没有访问权限');
				}else{
					$this->error('您没有访问权限');
				}
			}
		}
        $this->Menu = D("Menu");
		$this -> get_menu1();
	}
	public function get_menu1(){
		// header('content-type:text/html;charset=utf-8');
		$this->cate = F("Menu");
		if(!$this->cate){
    		$res = $this->Menu->where(array('status'=>1))->order(array("sort" => "ASC"))->select();
    		if($res){
    			$this->cate = $res;
    		}
    		$this->Menu ->menu_cache($$this->cate);
		}
		
    	$menu = array(
			array('id'=>1,'name'=>'菜单管理','parentid'=>0,'sort'=>'1'),
			array('id'=>2,'name'=>'后台菜单','parentid'=>1,'sort'=>'1'),
			array('id'=>3,'name'=>'菜单列表','parentid'=>2,'sort'=>'2','module'=>'Adminn','controller'=>'Menu','action'=>'get_menu'),
			array('id'=>4,'name'=>'添加菜单','parentid'=>2,'sort'=>'1','module'=>'Adminn','controller'=>'Menu','action'=>'add_menu'),
			array('id'=>5,'name'=>'权限管理','parentid'=>0,'sort'=>'1'),
			array('id'=>6,'name'=>'规则列表','parentid'=>5,'sort'=>'1','module'=>'Adminn','controller'=>'Auth','action'=>'get_list'),
			array('id'=>7,'name'=>'添加规则','parentid'=>5,'sort'=>'2','module'=>'Adminn','controller'=>'Auth','action'=>'add_auth'),
			);
		$menu = array_merge($menu,$this->cate);
		$tree = new Tree2();
		$tree -> init($menu);
		$res = $tree -> get_tree_array(0);
		// dump($res);
     // menuArray
     	$this -> assign('menuArray',$res);
	}
}