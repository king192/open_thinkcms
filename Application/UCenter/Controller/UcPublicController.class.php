<?php
namespace UCenter\Controller;
use Think\Controller;

class UcPublicController extends Controller{
	public function _initialize(){
		define('UID', is_mlogin());
		// dump(UID);
		// dump(cookie('userAuth'));
		if(!UID){
			if(IS_AJAX){
				json_rtn(-9,'请登陆后操作');
			}
			header('location:'.U('User/UserLogin/index'));
			exit('you are not login!');
		}
		$user = cookie('userAuth');
		$real_user = get_user_info('lastlgtm');
		// dump($user['lastlgtm']);
		// dump();
		if($user['lastlgtm'] != $real_user['lastlgtm']){
			set_logout();
			// echo 'tm no';
			header('content-type:text/html;charset=utf-8');
			exit('您的账户已在其他地方登陆，请重新登录<a href="'.U("User/UserLogin/index").'">确定</a>');

		}

	}
}