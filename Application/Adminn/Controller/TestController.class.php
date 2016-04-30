<?php
namespace Adminn\Controller;
use Think\Controller;
use Vendor\my\Tree as Tree2;

class TestController extends BaseController{
	public function hello(){
		$passwd = \Vendor\my\User::passwd_encode('123456');
		dump(session('adminAuth'));
		dump($passwd);
		json_rtn(1,'hello');
	}
	public function hi(){
		dump(LOGIN_ADMIN);
		json_rtn(2,'hi');

	}
	public function how(){
		json_rtn(3,'how');
	}
	public function ser(){
		$data = array(
			array('auth_access_id'=>1),
			array('auth_access_id'=>5),
			array('auth_access_id'=>3),
			array('auth_access_id'=>3),
			array('auth_access_id'=>5),
			);
		$res = $this->array_multi_unique($data);
		dump($res);
		array_multisort($res);
		dump($res,true,'sortarray');
	}
	/**
	 * 去除二维数组中重复的一维数组
	 * @param  array $ar 二维数组
	 * @return array     [description]
	 */
	function array_multi_unique($ar) {
	  $ar = array_map('serialize', $ar);//二维数组序列化后变一维数组
	  dump($ar,true,'ar');
	  $ar = array_unique($ar);//然后把相同值去掉
	  return array_map('unserialize', $ar);//反序列化
	}
}