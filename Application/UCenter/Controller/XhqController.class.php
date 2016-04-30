<?php
namespace UCenter\Controller;
use UCenter\Controller\UcPublicController;

class XhqController extends UcPublicController {
	public function credit(){
		// // dump('uid:',UID);
		// 	trace('hello110','错误','ERR');
		// $res = D('Common/Credit') -> inc_credit(5,1,3);
		// // $res = D('Common/Credit') -> hello();
		// dump($res);
	}
	public function m(){
		$user = M('User');
		$userinfo = $user->select();
		dump($userinfo);
	}
	public function d(){
		$user = D('User');
		$userinfo = $user->select();
		dump($userinfo);
	}
}