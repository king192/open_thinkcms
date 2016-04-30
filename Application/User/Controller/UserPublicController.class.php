<?php 
namespace User\Controller;
use Think\Controller;

class UserPublicController extends Controller{
	public function _initialize(){
		define('LOGIN_UID', is_login());
		// dump(LOGIN_UID);
		// if(!LOGIN_UID){
		// 	exit('you are not login!');
		// }

	}
	// public function index(){
	// 	echo 'hello';
	// }

}